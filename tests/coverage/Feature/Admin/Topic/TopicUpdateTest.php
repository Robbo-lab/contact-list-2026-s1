<?php

declare(strict_types=1);

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('denies unauthenticated users from editing a topic', function (): void {
    $response = $this->get(route('admin.topics.edit', 1));

    $response->assertRedirect(route('login'));
});

it('denies unauthenticated users from updating a topic via PUT', function (): void {
    $response = $this->put(route('admin.topics.update', 1));

    $response->assertRedirect(route('login'));
});

it('denies unauthenticated users from updating a topic via PATCH', function (): void {
    $response = $this->patch(route('admin.topics.update', 1));

    $response->assertRedirect(route('login'));
});

it('shows edit page for existing topic', function (): void {
    $topic = Topic::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('admin.topics.edit', $topic));

    $response->assertStatus(200);
    $response->assertSee($topic->name);
});

it('redirects when topic is missing', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('admin.topics.edit', 999));

    $response->assertRedirect(route('admin.topics.index'));
    $response->assertSessionHas('error');
});

it('fails update when name is missing', function (): void {
    $topic = Topic::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->put(route('admin.topics.update', $topic), [
            'name' => '',
            'description' => 'Updated',
            'available' => true,
        ]);

    $response->assertSessionHasErrors('name');
});

it('updates topic when valid', function (): void {
    $topic = Topic::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->put(route('admin.topics.update', $topic), [
            'name' => 'Updated Name',
            'description' => 'Updated',
            'available' => true,
        ]);

    $this->assertDatabaseHas('topics', [
        'name' => 'Updated Name',
    ]);
});

it('fails update when topic name already exists', function (): void {
    Topic::factory()->create(['name' => 'Existing']);

    $topic = Topic::factory()->create(['name' => 'Original']);
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->put(route('admin.topics.update', $topic), [
            'name' => 'Existing',
        ]);

    $response->assertSessionHasErrors('name');
});
