<?php

declare(strict_types=1);

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Unauthenticated Delete Action', function (): void {
    it('denies unauthenticated users from delete topic confirmation via GET', function (): void {
        $response = $this->get(route('admin.topics.delete-confirm', 1));

        $response->assertRedirect(route('login'));
    });

    it('denies unauthenticated users from delete topic confirmation via POST', function (): void {
        $response = $this->post(route('admin.topics.delete-confirm', 1));

        $response->assertRedirect(route('login'));
    });

    it('denies unauthenticated users from destroying a topic', function (): void {
        $response = $this->delete(route('admin.topics.destroy', 1));

        $response->assertRedirect(route('login'));
    });
});

describe('Authenticated Delete Action', function (): void {

    it('shows delete confirmation for existing topic', function (): void {
        $topic = Topic::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.topics.delete', $topic));

        $response->assertStatus(200);
        $response->assertSee('Confirm Delete');
    });

    it('redirects when deleting missing topic', function (): void {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.topics.delete', 999));

        $response->assertRedirect(route('admin.topics.index'));
        $response->assertSessionHas('error');
    });

    it('fails destroy when topic missing', function (): void {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.topics.destroy', 999));

        $response->assertRedirect(route('admin.topics.index'));
        $response->assertSessionHas('error');
    });

    it('requires confirmation before deleting', function (): void {
        $topic = Topic::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.topics.destroy', $topic), [
                'name_confirmation' => null,
            ]);

        $response->assertRedirect(route('admin.topics.delete', $topic));
        $response->assertSessionHas('error');
    });

    it('deletes topic with valid confirmation', function (): void {
        $topic = Topic::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.topics.destroy', $topic), [
                'confirm' => true,
            ]);

        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
        ]);
    });

});
