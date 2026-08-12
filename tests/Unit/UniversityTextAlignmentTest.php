<?php

test('about university narrative content uses justified alignment', function () {
    $universityPage = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/pages/about/University.vue',
    );

    expect(substr_count($universityPage, 'text-justify'))->toBe(8)
        ->and($universityPage)
        ->toContain('whitespace-pre-line text-sm leading-7');
});
