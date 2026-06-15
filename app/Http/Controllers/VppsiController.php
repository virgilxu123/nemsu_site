<?php

namespace App\Http\Controllers;

use App\Models\BacMatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class VppsiController extends Controller
{
    /**
     * @var array<string, array{label: string, types: list<string>}>
     */
    private const FILTERS = [
        'RFQ' => [
            'label' => 'Request for Quotation',
            'types' => ['RFQ'],
        ],
        'ITB' => [
            'label' => 'Invitation to Bid',
            'types' => ['ITB'],
        ],
        'NOA' => [
            'label' => 'Notice of Award',
            'types' => ['NOA'],
        ],
        'NTP' => [
            'label' => 'Notice to Proceed',
            'types' => ['NTP'],
        ],
        'Bid Bulletin' => [
            'label' => 'Bid Bulletin',
            'types' => ['Bid Bulletin', 'Bid Bulletin 2'],
        ],
    ];

    public function __invoke(Request $request): Response
    {
        $type = (string) $request->query('type', 'RFQ');
        $activeType = array_key_exists($type, self::FILTERS) ? $type : 'RFQ';

        return Inertia::render('administration/Vppsi', [
            'filters' => [
                'activeType' => $activeType,
                'options' => collect(self::FILTERS)
                    ->map(fn (array $filter, string $value): array => [
                        'label' => $filter['label'],
                        'value' => $value,
                    ])
                    ->values(),
            ],
            'matters' => BacMatter::query()
                ->select(['id', 'name', 'file', 'link', 'type', 'date'])
                ->where('is_published', true)
                ->whereIn('type', self::FILTERS[$activeType]['types'])
                ->latest('date')
                ->latest('id')
                ->paginate(10)
                ->withQueryString()
                ->through(fn (BacMatter $matter): array => $this->matterListData($matter)),
        ]);
    }

    /**
     * @return array{id: int, name: string, type: string, date: string|null, destinationUrl: string|null}
     */
    private function matterListData(BacMatter $matter): array
    {
        return [
            'id' => $matter->id,
            'name' => $matter->name,
            'type' => self::FILTERS[$matter->type === 'Bid Bulletin 2' ? 'Bid Bulletin' : $matter->type]['label'],
            'date' => $matter->date?->format('F j, Y'),
            'destinationUrl' => $this->fileUrl($matter->file) ?? $this->absoluteLegacyUrl($matter->link),
        ];
    }

    private function fileUrl(?string $file): ?string
    {
        if (! filled($file)) {
            return null;
        }

        if (Str::of($file)->startsWith('bac-matters/')) {
            return Storage::disk('public')->url($file);
        }

        return $this->absoluteLegacyUrl($file);
    }

    private function absoluteLegacyUrl(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $url = Str::of(html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            ->stripTags()
            ->squish()
            ->toString();

        if ($url === '') {
            return null;
        }

        if (Str::of($url)->startsWith(['http://', 'https://'])) {
            return $url;
        }

        if (Str::of($url)->startsWith('/')) {
            return 'https://nemsu.edu.ph'.$url;
        }

        return 'https://nemsu.edu.ph/files/BAC/'.rawurlencode($url);
    }
}
