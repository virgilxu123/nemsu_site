<?php

use Tests\TestCase;

uses(TestCase::class);

test('services page hides the website action when the url is blank', function () {
    $page = file_get_contents(resource_path('js/pages/services/Index.vue'));

    expect($page)
        ->toContain('v-if="service.url?.trim()"')
        ->toContain(':href="service.url"')
        ->toContain('Visit Website');
});
