<?php

use Illuminate\Support\Facades\Route;

test('forwarded https headers generate secure application and asset urls', function () {
    Route::get('/__test/secure-asset-urls', fn () => response()->json([
        'root' => url('/'),
        'asset' => asset('build/app.css'),
    ]));

    $response = $this->withHeaders([
        'X-Forwarded-For' => '203.0.113.10',
        'X-Forwarded-Host' => 'nemsu.example.test',
        'X-Forwarded-Port' => '443',
        'X-Forwarded-Proto' => 'https',
    ])->get('/__test/secure-asset-urls');

    $response
        ->assertOk()
        ->assertJson([
            'root' => 'https://nemsu.example.test',
            'asset' => 'https://nemsu.example.test/build/app.css',
        ]);

    expect($response->json('asset'))->not->toStartWith('http://');
});

test('configured asset url is used as the generated asset origin', function () {
    config(['app.asset_url' => 'https://cdn.example.test']);

    app()->forgetInstance('url');

    expect(asset('build/app.css'))->toBe('https://cdn.example.test/build/app.css');
});
