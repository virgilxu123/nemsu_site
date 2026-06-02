<?php

use App\Models\ContentPage;
use App\Models\NavigationItem;
use Inertia\Testing\AssertableInertia as Assert;

test('published content pages render publicly', function () {
    $contentPage = ContentPage::factory()->published()->create([
        'title' => 'Vision and Mission',
        'slug' => 'vision-and-mission',
        'body' => '<p>Public page body.</p>',
    ]);

    $this->get(route('content-pages.show', $contentPage->slug))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('content/Show')
            ->where('page.title', 'Vision and Mission')
            ->where('page.slug', 'vision-and-mission')
        );
});

test('draft unpublished and future published content pages are hidden', function () {
    $draft = ContentPage::factory()->draft()->create();
    $future = ContentPage::factory()->published()->create([
        'published_at' => now()->addDay(),
    ]);

    $this->get(route('content-pages.show', $draft->slug))
        ->assertNotFound();

    $this->get(route('content-pages.show', $future->slug))
        ->assertNotFound();
});

test('shared navigation includes active ordered items and resolves content page targets', function () {
    $contentPage = ContentPage::factory()->published()->create([
        'slug' => 'vision-and-mission',
    ]);
    $main = NavigationItem::factory()->create([
        'label' => 'Vision',
        'url' => null,
        'target_type' => 'content_page',
        'target_id' => $contentPage->id,
        'sort_order' => 2,
    ]);
    $child = NavigationItem::factory()->create([
        'label' => 'Child Link',
        'parent_id' => $main->id,
        'url' => '/child-link',
        'sort_order' => 1,
    ]);
    NavigationItem::factory()->inactive()->create([
        'label' => 'Hidden Link',
        'sort_order' => 1,
    ]);
    $footer = NavigationItem::factory()->footer()->create([
        'label' => 'Privacy',
        'url' => '/privacy',
    ]);

    $this->get(route('content-pages.show', $contentPage->slug))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('navigation.main.0.id', $main->id)
            ->where('navigation.main.0.url', '/pages/vision-and-mission')
            ->where('navigation.main.0.children.0.id', $child->id)
            ->where('navigation.footer.0.id', $footer->id)
        );
});
