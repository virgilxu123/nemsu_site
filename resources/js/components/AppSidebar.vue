<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    BookOpen,
    FileText,
    FolderGit2,
    Image as ImageIcon,
    LayoutGrid,
    Megaphone,
    MenuSquare,
    Newspaper,
} from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { index as adminAnnouncementsIndex } from '@/routes/admin/announcements';
import { index as adminBannersIndex } from '@/routes/admin/banners';
import { index as adminContentPagesIndex } from '@/routes/admin/content-pages';
import { index as adminNavigationIndex } from '@/routes/admin/navigation';
import { index as adminNewsIndex } from '@/routes/admin/news';
import type { Auth, NavItem } from '@/types';

const page = usePage<{ auth: Auth }>();

const mainNavItems = computed<NavItem[]>(() => [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    ...(page.props.auth.can.manageCms
        ? [
              {
                  title: 'Content Pages',
                  href: adminContentPagesIndex(),
                  icon: FileText,
              },
              {
                  title: 'News',
                  href: adminNewsIndex(),
                  icon: Newspaper,
              },
              {
                  title: 'Announcements',
                  href: adminAnnouncementsIndex(),
                  icon: Megaphone,
              },
              {
                  title: 'Banners',
                  href: adminBannersIndex(),
                  icon: ImageIcon,
              },
              {
                  title: 'Navigation',
                  href: adminNavigationIndex(),
                  icon: MenuSquare,
              },
          ]
        : []),
]);

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
