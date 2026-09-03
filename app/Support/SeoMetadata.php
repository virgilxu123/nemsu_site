<?php

namespace App\Support;

use App\Models\ContentPage;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoMetadata
{
    /**
     * @return array<string, mixed>
     */
    public function forRequest(Request $request): array
    {
        $routeName = $request->route()?->getName();
        $metadata = $this->routeMetadata($routeName, $request);
        $isIndexable = ! Str::of((string) $routeName)->startsWith([
            'admin.',
            'dashboard',
            'login',
            'password.',
            'profile.',
            'security.',
            'appearance.',
        ]) && ! Str::contains((string) $routeName, 'content_preview');

        return $this->page(
            title: $metadata['title'],
            description: $metadata['description'],
            canonical: $request->url(),
            robots: $isIndexable ? 'index, follow' : 'noindex, nofollow',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function forNews(News $news, string $title, string $description, ?string $image): array
    {
        $canonical = route('news.show', $news);
        $articleType = $news->type === 'announcement' ? 'Announcement' : 'Press Release';
        $publisher = $this->organizationSchema(false);
        $schema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $title,
            'description' => $description,
            'mainEntityOfPage' => $canonical,
            'datePublished' => $news->date?->toAtomString(),
            'dateModified' => $news->updated_at?->toAtomString(),
            'articleSection' => $articleType,
            'author' => [
                '@type' => 'Organization',
                'name' => filled($news->author) ? $news->author : config('seo.organization_name'),
            ],
            'publisher' => $publisher,
            'image' => $image === null ? null : [$this->absoluteAssetUrl($image)],
        ], fn (mixed $value): bool => $value !== null);

        return $this->page(
            title: $title,
            description: $description,
            canonical: $canonical,
            image: $image,
            type: 'article',
            schema: [
                $schema,
                $this->breadcrumbSchema([
                    ['name' => 'Home', 'url' => route('home')],
                    ['name' => 'Newsroom', 'url' => route('news.index')],
                    ['name' => $title, 'url' => $canonical],
                ]),
            ],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function forContentPage(ContentPage $contentPage): array
    {
        $canonical = route('content-pages.show', $contentPage);
        $description = filled($contentPage->excerpt)
            ? Str::limit(strip_tags((string) $contentPage->excerpt), 160)
            : config('seo.description');

        return $this->page(
            title: $contentPage->title,
            description: $description,
            canonical: $canonical,
            schema: [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => $contentPage->title,
                    'description' => $description,
                    'url' => $canonical,
                    'datePublished' => $contentPage->published_at?->toAtomString(),
                    'dateModified' => $contentPage->updated_at?->toAtomString(),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => config('seo.site_name'),
                        'url' => route('home'),
                    ],
                ],
                $this->breadcrumbSchema([
                    ['name' => 'Home', 'url' => route('home')],
                    ['name' => $contentPage->title, 'url' => $canonical],
                ]),
            ],
        );
    }

    /**
     * @param  list<array<string, mixed>>  $schema
     * @return array<string, mixed>
     */
    public function page(
        string $title,
        string $description,
        string $canonical,
        ?string $image = null,
        string $type = 'website',
        string $robots = 'index, follow',
        array $schema = [],
    ): array {
        $siteName = (string) config('seo.site_name');
        $fullTitle = $title === config('seo.organization_name')
            ? $title
            : "{$title} | {$siteName}";
        $imageUrl = $this->absoluteAssetUrl($image ?? (string) config('seo.default_image'));

        if ($schema === []) {
            $schema[] =
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => $fullTitle,
                    'description' => $description,
                    'url' => $canonical,
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => $siteName,
                        'url' => route('home'),
                    ],
                ];
        }

        $schema = [
            $this->organizationSchema(),
            $this->websiteSchema(),
            ...$schema,
        ];

        return [
            'title' => $title,
            'fullTitle' => $fullTitle,
            'description' => $description,
            'keywords' => config('seo.keywords'),
            'canonical' => $canonical,
            'image' => $imageUrl,
            'type' => $type,
            'robots' => $robots,
            'locale' => config('seo.locale'),
            'siteName' => $siteName,
            'googleSiteVerification' => config('seo.google_site_verification'),
            'schema' => $schema,
        ];
    }

    /**
     * @return array{title: string, description: string}
     */
    private function routeMetadata(?string $routeName, Request $request): array
    {
        return match ($routeName) {
            'home' => [
                'title' => config('seo.organization_name'),
                'description' => config('seo.description'),
            ],
            'news.index' => [
                'title' => 'NEMSU Newsroom',
                'description' => 'Read official NEMSU news, press releases, announcements, campus milestones, research updates, and public information releases.',
            ],
            'announcements.index' => [
                'title' => 'Announcements',
                'description' => 'View official announcements, notices, and public advisories from North Eastern Mindanao State University.',
            ],
            'about.university' => [
                'title' => 'About the University',
                'description' => 'Learn about NEMSU, its history, mandate, vision, mission, core values, and commitment to education and public service.',
            ],
            'about.board-of-regents' => [
                'title' => 'Board of Regents',
                'description' => 'Meet the Board of Regents governing North Eastern Mindanao State University.',
            ],
            'about.office-of-the-president' => [
                'title' => 'Office of the President',
                'description' => 'Explore the leadership, priorities, and strategic agenda of the NEMSU Office of the President.',
            ],
            'academics.academic-affairs' => [
                'title' => 'Academic Affairs',
                'description' => 'Explore NEMSU academic colleges, graduate studies, programs, and academic support offices.',
            ],
            'academics.academic-affairs.colleges.show' => $this->parameterMetadata(
                $request,
                'college',
                'Explore this NEMSU college, its academic programs, campus offerings, and program information.',
            ),
            'academics.academic-affairs.graduate-professional-studies.show' => $this->parameterMetadata(
                $request,
                'study',
                'Explore NEMSU graduate and professional programs, campus offerings, and prospectus information.',
            ),
            'academics.academic-affairs.offices.show',
            'administration.vpaf.offices.show',
            'administration.vppsi.offices.show',
            'research.rie.offices.show' => $this->parameterMetadata(
                $request,
                'office',
                'Learn about this NEMSU office, its mandate, leadership, services, and contact information.',
            ),
            'campuses.show' => $this->campusMetadata($request),
            'administration.vpaf' => [
                'title' => 'Administration and Finance',
                'description' => 'Learn about NEMSU administrative, financial, human resource, procurement, and campus support services.',
            ],
            'administration.vppsi' => [
                'title' => 'Planning and Strategic Initiatives',
                'description' => 'Explore NEMSU institutional planning, quality assurance, strategic initiatives, and development priorities.',
            ],
            'administration.good-governance' => [
                'title' => 'Good Governance',
                'description' => 'Access NEMSU good governance, accountability, freedom of information, and public disclosure resources.',
            ],
            'administration.citizens-charter' => [
                'title' => "Citizen's Charter",
                'description' => "Access the NEMSU Citizen's Charter, service standards, requirements, and processing information.",
            ],
            'administration.transparency-seal' => [
                'title' => 'Transparency Seal',
                'description' => 'Access NEMSU transparency disclosures, financial reports, procurement records, and public accountability documents.',
            ],
            'research.rie' => [
                'title' => 'Research, Innovation, and Extension',
                'description' => 'Discover NEMSU research, innovation, extension programs, research centers, and scholarly publications.',
            ],
            'research.rie.centers' => [
                'title' => 'Research Centers',
                'description' => 'Explore NEMSU research centers, laboratories, expertise, programs, and regional research priorities.',
            ],
            'research.rie.publications.index' => [
                'title' => 'Research Publications',
                'description' => 'Browse scholarly articles, journals, and research publications produced by the NEMSU academic community.',
            ],
            'services.index' => [
                'title' => 'Online Services',
                'description' => 'Access official online services and digital resources for NEMSU students, employees, and stakeholders.',
            ],
            'directory' => [
                'title' => 'University Directory',
                'description' => 'Find contact information for NEMSU officials, offices, and campuses.',
            ],
            default => [
                'title' => config('seo.organization_name'),
                'description' => config('seo.description'),
            ],
        };
    }

    /**
     * @return array{title: string, description: string}
     */
    private function campusMetadata(Request $request): array
    {
        $campus = (string) $request->route('campus');
        $profile = config("campus_profiles.{$campus}");

        if (! is_array($profile)) {
            return $this->parameterMetadata($request, 'campus', config('seo.description'));
        }

        return [
            'title' => (string) ($profile['name'] ?? Str::headline($campus)),
            'description' => Str::limit(
                (string) data_get($profile, 'profile.overview', config('seo.description')),
                160,
            ),
        ];
    }

    /**
     * @return array{title: string, description: string}
     */
    private function parameterMetadata(Request $request, string $parameter, string $description): array
    {
        return [
            'title' => Str::headline((string) $request->route($parameter)),
            'description' => $description,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function organizationSchema(bool $withContext = true): array
    {
        return array_filter([
            '@context' => $withContext ? 'https://schema.org' : null,
            '@type' => 'CollegeOrUniversity',
            'name' => config('seo.organization_name'),
            'alternateName' => config('seo.site_name'),
            'url' => route('home'),
            'logo' => $this->absoluteAssetUrl((string) config('seo.logo')),
            'description' => config('seo.description'),
            'address' => [
                '@type' => 'PostalAddress',
                ...(array) config('seo.address', []),
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'University information',
                'telephone' => config('seo.telephone'),
                'email' => config('seo.email'),
            ],
            'sameAs' => config('seo.same_as', []),
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>
     */
    private function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('seo.site_name'),
            'alternateName' => config('seo.organization_name'),
            'url' => route('home'),
            'publisher' => $this->organizationSchema(false),
        ];
    }

    /**
     * @param  list<array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    private function breadcrumbSchema(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)
                ->values()
                ->map(fn (array $item, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ])
                ->all(),
        ];
    }

    private function absoluteAssetUrl(string $asset): string
    {
        return Str::of($asset)->startsWith(['http://', 'https://'])
            ? $asset
            : url($asset);
    }
}
