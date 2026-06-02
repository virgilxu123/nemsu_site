<?php

use App\Models\ContentPage;
use App\Models\NavigationItem;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

function navigationAdminUser(): User
{
    return User::factory()->create([
        'account_type' => 'admin',
    ]);
}

function navigationItemPayload(array $overrides = []): array
{
    return [
        'location' => 'main',
        'label' => 'About',
        'parent_id' => null,
        'url' => '/about',
        'route_name' => '',
        'target_type' => '',
        'target_id' => '',
        'sort_order' => 1,
        'is_active' => '1',
        ...$overrides,
    ];
}

test('guests are redirected to login from admin navigation', function () {
    $this->get(route('admin.navigation.index'))
        ->assertRedirect(route('login'));
});

test('non admin users cannot manage navigation', function () {
    $user = User::factory()->create([
        'account_type' => 'contributor',
    ]);

    $this->actingAs($user)
        ->get(route('admin.navigation.index'))
        ->assertForbidden();
});

test('admins can view navigation management pages', function () {
    $admin = navigationAdminUser();
    $navigationItem = NavigationItem::factory()->create([
        'label' => 'About',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.navigation.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/navigation/Index')
            ->has('items.data', 1)
            ->where('items.data.0.id', $navigationItem->id)
        );

    $this->actingAs($admin)
        ->get(route('admin.navigation.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('admin/navigation/Create'));

    $this->actingAs($admin)
        ->get(route('admin.navigation.edit', $navigationItem))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/navigation/Edit')
            ->where('item.id', $navigationItem->id)
        );
});

test('admins can store navigation items targeting content pages', function () {
    $admin = navigationAdminUser();
    $contentPage = ContentPage::factory()->published()->create([
        'slug' => 'vision-and-mission',
    ]);

    $response = $this->actingAs($admin)
        ->post(route('admin.navigation.store'), navigationItemPayload([
            'label' => 'Vision',
            'url' => '',
            'target_type' => 'content_page',
            'target_id' => $contentPage->id,
        ]));

    $navigationItem = NavigationItem::query()->firstOrFail();

    $response->assertRedirect(route('admin.navigation.edit', $navigationItem));

    expect($navigationItem->label)->toBe('Vision')
        ->and($navigationItem->target_type)->toBe('content_page')
        ->and($navigationItem->target_id)->toBe($contentPage->id)
        ->and($navigationItem->is_active)->toBeTrue();
});

test('admins can update and delete navigation items', function () {
    $admin = navigationAdminUser();
    $navigationItem = NavigationItem::factory()->create([
        'label' => 'About',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.navigation.update', $navigationItem), navigationItemPayload([
            'label' => 'Updated About',
            'is_active' => '0',
        ]))
        ->assertRedirect(route('admin.navigation.edit', $navigationItem));

    expect($navigationItem->refresh()->label)->toBe('Updated About')
        ->and($navigationItem->is_active)->toBeFalse();

    $this->actingAs($admin)
        ->delete(route('admin.navigation.destroy', $navigationItem))
        ->assertRedirect(route('admin.navigation.index'));

    $this->assertModelMissing($navigationItem);
});

test('navigation parent must be in the same location and cannot point to itself', function () {
    $admin = navigationAdminUser();
    $footerParent = NavigationItem::factory()->footer()->create();
    $navigationItem = NavigationItem::factory()->create();

    $this->actingAs($admin)
        ->from(route('admin.navigation.edit', $navigationItem))
        ->patch(route('admin.navigation.update', $navigationItem), navigationItemPayload([
            'parent_id' => $footerParent->id,
        ]))
        ->assertRedirect(route('admin.navigation.edit', $navigationItem))
        ->assertSessionHasErrors('parent_id');

    $this->actingAs($admin)
        ->from(route('admin.navigation.edit', $navigationItem))
        ->patch(route('admin.navigation.update', $navigationItem), navigationItemPayload([
            'parent_id' => $navigationItem->id,
        ]))
        ->assertRedirect(route('admin.navigation.edit', $navigationItem))
        ->assertSessionHasErrors('parent_id');
});

test('admin navigation index filters active items and sorts by order', function () {
    $admin = navigationAdminUser();
    $first = NavigationItem::factory()->create([
        'label' => 'First',
        'sort_order' => 1,
    ]);
    NavigationItem::factory()->inactive()->create([
        'label' => 'Second',
        'sort_order' => 2,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.navigation.index', [
            'active' => 'active',
            'sort_by' => 'sort_order',
            'sort_direction' => 'asc',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('items.data', 1)
            ->where('items.data.0.id', $first->id)
        );
});
