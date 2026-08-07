<?php

test('the application uses its local brand typefaces', function () {
    $projectRoot = dirname(__DIR__, 2);
    $stylesheet = file_get_contents($projectRoot.'/resources/css/app.css');

    expect($projectRoot.'/public/fonts/delight/delight-vf.ttf')
        ->toBeFile()
        ->and($projectRoot.'/public/fonts/polysans/polysanstrial-neutral.otf')
        ->toBeFile()
        ->and(
            $projectRoot.
                '/public/fonts/polysans/polysansitalictrial-neutralitalic.otf',
        )
        ->toBeFile()
        ->and($stylesheet)
        ->toContain(
            "font-family: 'Delight'",
            "url('/fonts/delight/delight-vf.ttf')",
            "font-family: 'PolySans Trial Neutral'",
            "url('/fonts/polysans/polysanstrial-neutral.otf')",
            "url('/fonts/polysans/polysansitalictrial-neutralitalic.otf')",
            "--font-sans:\n        'PolySans Trial Neutral'",
            '--font-delight: Delight',
            '@apply font-delight;',
        )
        ->not->toContain('fonts.googleapis.com', '--font-allura');
});
