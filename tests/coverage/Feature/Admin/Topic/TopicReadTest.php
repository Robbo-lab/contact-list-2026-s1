<?php

declare(strict_types=1);

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('denies unauthenticated users from browsing topics', function (): void {
    $response = $this->get(route('admin.topics.index'));

    $response->assertRedirect(route('login'));
});

it('denies unauthenticated users from reading a topic', function (): void {
    $response = $this->get(route('admin.topics.show', 1));

    $response->assertRedirect(route('login'));
});

it('shows topics when seeded', function () {
    Topic::factory()->count(3)->create();

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.topics.index'));

    $response->assertStatus(200);
    $response->assertSee(Topic::first()->name);
});


it('shows no topics message when none exist', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.topics.index'));

    $response->assertStatus(200);
    $response->assertSee('No topics available');
});

it('shows topic when topic exists', function () {
    $topic = Topic::factory()->count(1)->create();

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.topics.show', $topic->id));

    $response->assertStatus(200);
    $response->assertSee(Topic::first()->name);
});


it('shows 404 when topic does not exist', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.topics.index',0));

    $response->assertStatus(404);
});
