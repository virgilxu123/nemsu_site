<?php

use App\Models\BacMatter;
use Inertia\Testing\AssertableInertia as Assert;

test('the public vppsi page defaults to published requests for quotation', function () {
    $requestForQuotation = BacMatter::factory()->published()->create([
        'name' => 'Published RFQ',
        'type' => 'RFQ',
        'date' => '2026-06-15 08:00:00',
    ]);
    BacMatter::factory()->create([
        'name' => 'Draft RFQ',
        'type' => 'RFQ',
    ]);
    BacMatter::factory()->published()->create([
        'name' => 'Published ITB',
        'type' => 'ITB',
    ]);

    $this->get(route('administration.vppsi'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('administration/Vppsi')
            ->where('filters.activeType', 'RFQ')
            ->has('filters.options', 5)
            ->has('matters.data', 1)
            ->where('matters.data.0.id', $requestForQuotation->id)
            ->where('matters.data.0.type', 'Request for Quotation')
        );
});

test('the public vppsi page filters bac matters and combines bulletin types', function () {
    $firstBulletin = BacMatter::factory()->published()->create([
        'name' => 'First Bulletin',
        'type' => 'Bid Bulletin',
    ]);
    $secondBulletin = BacMatter::factory()->published()->create([
        'name' => 'Second Bulletin',
        'type' => 'Bid Bulletin 2',
    ]);
    BacMatter::factory()->published()->create([
        'name' => 'Unrelated RFQ',
        'type' => 'RFQ',
    ]);

    $this->get(route('administration.vppsi', ['type' => 'Bid Bulletin']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('filters.activeType', 'Bid Bulletin')
            ->has('matters.data', 2)
            ->where('matters.data.0.type', 'Bid Bulletin')
            ->where('matters.data.1.type', 'Bid Bulletin')
            ->where('matters.data', fn ($matters) => collect($matters)
                ->pluck('id')
                ->contains($firstBulletin->id)
                && collect($matters)->pluck('id')->contains($secondBulletin->id))
        );
});
