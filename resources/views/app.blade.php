<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])

        <style>
            :root {
                --color-brand-navy: #08045f;
                --color-brand-blue: #1711d4;
                --color-brand-teal: #0b6680;
                --color-brand-maroon: #9b1c31;
                --color-brand-gold: #f2b705;
                --color-bg-page: #f7f8f5;
                --color-bg-section: #f5f8ff;
                --color-bg-hero: #eef2ff;
                --color-bg-teal-light: #e6f3f5;
                --color-bg-pink-light: #f8e7eb;
            }

            .dark {
                --color-brand-navy: #f2b705;
                --color-brand-blue: #f2b705;
                --color-brand-teal: #7dd3fc;
                --color-brand-maroon: #fda4af;
                --color-brand-gold: #f2b705;
                --color-bg-page: #0b0f19;
                --color-bg-section: #0f172a;
                --color-bg-hero: #0f172a;
                --color-bg-teal-light: #1e293b;
                --color-bg-pink-light: #2a0a0f;
            }

            .text-shadow-sm {
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            }

            .text-shadow-md {
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            }

            .text-shadow-black\/50 {
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            }

            .text-brand-navy {
                color: var(--color-brand-navy);
            }

            .text-brand-blue {
                color: var(--color-brand-blue);
            }

            .text-brand-teal {
                color: var(--color-brand-teal);
            }

            .text-brand-maroon {
                color: var(--color-brand-maroon);
            }

            .text-brand-gold {
                color: var(--color-brand-gold);
            }

            .bg-brand-navy {
                background-color: var(--color-brand-navy);
            }

            .bg-brand-blue {
                background-color: var(--color-brand-blue);
            }

            .bg-brand-teal {
                background-color: var(--color-brand-teal);
            }

            .bg-brand-maroon {
                background-color: var(--color-brand-maroon);
            }

            .bg-brand-gold {
                background-color: var(--color-brand-gold);
            }

            .bg-page {
                background-color: var(--color-bg-page);
            }

            .bg-section {
                background-color: var(--color-bg-section);
            }

            .bg-hero {
                background-color: var(--color-bg-hero);
            }

            .bg-teal-light {
                background-color: var(--color-bg-teal-light);
            }

            .bg-pink-light {
                background-color: var(--color-bg-pink-light);
            }
            .font-allura {
                font-family: "Allura", cursive;
                font-weight: 400;
                font-style: normal;
            }

        </style>
        <x-inertia::head>
            <title>{{ config('app.name', 'Laravel') }}</title>
        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
