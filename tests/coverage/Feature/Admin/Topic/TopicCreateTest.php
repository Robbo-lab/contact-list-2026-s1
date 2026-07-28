<?php

declare(strict_types=1);

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('denies unauthenticated users from creating a topic', function (): void {
    $response = $this->get(route('admin.topics.create', 1));

    $response->assertRedirect(route('login'));
});

it('denies unauthenticated users from storing a new topic', function (): void {
    $response = $this->post(route('admin.topics.store', 1));

    $response->assertRedirect(route('login'));
});

it('shows add topic page', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('admin.topics.create'));

    $response->assertStatus(200);
});

it('fails when topic name is missing', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('admin.topics.store'), [
            'name' => '',
            'description' => 'Test description',
            'available' => true,
        ]);

    $response->assertSessionHasErrors('name');
    $response->assertSessionHasInput('description', 'Test description');
    $response->assertSessionHasInput('available', true);
});

it('creates topic when valid and unique', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('admin.topics.store'), [
            'name' => 'Laravel',
            'description' => 'Framework',
            'available' => true,
        ]);

    $response->assertRedirect(route('admin.topics.index'));

    $this->assertDatabaseHas('topics', [
        'name' => 'Laravel',
    ]);
});

it('fails when topic already exists', function (): void {
    Topic::factory()->create(['name' => 'Laravel']);

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('admin.topics.store'), [
            'name' => 'Laravel',
            'description' => 'Duplicate',
            'available' => true,
        ]);

    $response->assertSessionHasErrors('name');
});
