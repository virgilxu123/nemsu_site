<?php

test('the public site layout is a thin composition', function () {
    $layout = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/layouts/PublicSiteLayout.vue',
    );

    expect($layout)
        ->toContain(
            "import PublicSiteHeader from '@/components/public-site/PublicSiteHeader.vue'",
        )
        ->toContain(
            "import PublicSiteFooter from '@/components/public-site/PublicSiteFooter.vue'",
        )
        ->toContain('<PublicSiteHeader />')
        ->toContain('<main>')
        ->toContain('<slot />')
        ->toContain('<PublicSiteFooter />')
        ->not->toContain('usePage')
        ->not->toContain('setInterval')
        ->not->toContain('publicSiteNavigationGroups')
        ->and(substr_count($layout, "\n"))
        ->toBeLessThan(30);
});

test('public site navigation is typed and backed by wayfinder routes', function () {
    $navigation = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/public-site-navigation.ts',
    );
    $types = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/types/public-site.ts',
    );
    $link = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/PublicSiteLink.vue',
    );

    expect($navigation)
        ->toContain("from '@/routes'")
        ->toContain("from '@/routes/about'")
        ->toContain("from '@/routes/academics'")
        ->toContain("from '@/routes/administration'")
        ->toContain("from '@/routes/campuses'")
        ->toContain("from '@/routes/research'")
        ->toContain("from '@/routes/services'")
        ->toContain('publicSiteNavigationGroups')
        ->toContain('publicSiteUtilityLinks')
        ->toContain('external: true')
        ->and($types)
        ->toContain('export type PublicSiteLinkItem')
        ->toContain('external?: boolean')
        ->toContain('export type PublicNewsTickerItem')
        ->and($link)
        ->toContain("import { Link } from '@inertiajs/vue3'")
        ->toContain(":is=\"external ? 'a' : Link\"");
});

test('the public news ticker owns and cleans up its rotation lifecycle', function () {
    $ticker = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/PublicNewsTicker.vue',
    );
    $header = file_get_contents(
        dirname(__DIR__, 2).
            '/resources/js/components/public-site/PublicSiteHeader.vue',
    );
    $globalTypes = file_get_contents(
        dirname(__DIR__, 2).'/resources/js/types/global.d.ts',
    );

    expect($ticker)
        ->toContain('window.setInterval')
        ->toContain('window.clearInterval')
        ->toContain('onMounted')
        ->toContain('onBeforeUnmount')
        ->toContain('tickerIndex.value = 0')
        ->toContain('props.items.length <= 1')
        ->toContain("from '@/routes/announcements'")
        ->toContain("from '@/routes/news'")
        ->and($header)
        ->toContain('usePage()')
        ->toContain('page.props.publicNewsTicker ?? []')
        ->toContain('<PublicNewsTicker :items="publicNewsTicker" />')
        ->and($globalTypes)
        ->toContain(
            "import type { PublicNewsTickerItem } from '@/types/public-site'",
        )
        ->not->toContain('type PublicNewsTickerItem =');
});
