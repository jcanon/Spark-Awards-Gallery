<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GalleryController extends BaseController
{
    private const CACHE_TTL_SHORT = 180;
    private const CACHE_TTL_MEDIUM = 300;

    public function index(?string $entryFromUri = null)
    {
        helper(['url', 'form', 'gallery']);

        $request = service('request');
        $model   = new GalleryModel();

        if ($request->getMethod(true) === 'POST') {
            $postedSearch = trim((string) $request->getPost('gallerysearch'));
            if ($postedSearch !== '') {
                return redirect()->to(site_url('gallery?search=' . urlencode($postedSearch)));
            }

            if ($request->getPost('submityear') !== null) {
                $postedYear = $this->normalizeYear($request->getPost('year'));
                if ($postedYear !== null) {
                    return redirect()->to(site_url("gallery?year={$postedYear}"));
                }
            }
        }

        $entry  = $this->normalizeEntry($entryFromUri ?? (string) $request->getGet('entry'));
        $search = trim((string) $request->getGet('search'));
        $year   = $this->normalizeYear($request->getGet('year')) ?? (int) date('Y');
        $comp   = $this->normalizeComp($request->getGet('comp'));

        $data = compact('entry', 'search', 'year', 'comp');
        $data['metaTitle']       = 'Galleries | Spark Awards - International Design Competition';
        $data['metaDescription'] = 'Browse Spark Awards gallery entries and winners by year and competition.';
        $data['canonicalUrl']    = $this->buildCompUrl($year, $comp);
        $data['ogImage']         = null;
        $data['backLink']        = null;

        if ($entry !== null) {
            $details = $this->timed('gallery.details', fn () => $model->getGalleryDetails($entry));
            if ($details === []) {
                log_message('warning', 'Gallery entry not found. entry={entry}, year={year}, comp={comp}', [
                    'entry' => $entry,
                    'year'  => (string) $year,
                    'comp'  => $comp,
                ]);
                throw PageNotFoundException::forPageNotFound("Entry not found: {$entry}");
            }

            $compDetails = $this->cachedValue(
                'gallery:comp:' . (int) $details['comp_id'],
                fn () => $this->timed('gallery.compById', fn () => $model->getCompByID((int) $details['comp_id'])),
                self::CACHE_TTL_MEDIUM
            );

            if (! is_array($compDetails) || $compDetails === []) {
                throw PageNotFoundException::forPageNotFound('Competition not found for requested entry.');
            }

            $year              = (int) $compDetails['comp_year'];
            $isWinnerContext   = ($comp === 'Winners');
            $activeCompContext = $isWinnerContext ? 'Winners' : ((string) $compDetails['comp_id']);

            $scopedEntries = $isWinnerContext
                ? $this->cachedValue(
                    "gallery:winners:{$year}",
                    fn () => $this->timed('gallery.winners', fn () => $model->getGalleryWinners((string) $year)),
                    self::CACHE_TTL_MEDIUM
                )
                : $this->cachedValue(
                    "gallery:entries:{$year}:{$compDetails['comp_type_id']}",
                    fn () => $this->timed('gallery.entries', fn () => $model->getGalleryEntries((string) $year, (string) $compDetails['comp_type_id'])),
                    self::CACHE_TTL_MEDIUM
                );

            $scopedIds = array_map('strval', array_column((array) $scopedEntries, 'entry_id'));
            $position  = array_search($entry, $scopedIds, true);

            $data['prevLink'] = ($position !== false && $position > 0)
                ? $this->buildEntryUrl($year, $activeCompContext, $scopedIds[$position - 1])
                : null;

            $data['nextLink'] = ($position !== false && $position < count($scopedIds) - 1)
                ? $this->buildEntryUrl($year, $activeCompContext, $scopedIds[$position + 1])
                : null;

            $designTypesList = '';
            if (! empty($details['design_type_list'])) {
                $designTypeIds = array_filter(array_map('intval', explode(',', (string) $details['design_type_list'])));
                $designTypeKey = 'gallery:design-types:' . md5(implode(',', $designTypeIds));
                $designTypeNames = $this->cachedValue(
                    $designTypeKey,
                    fn () => $model->getDesignTypeNamesByIDs($designTypeIds),
                    86400
                );
                $designTypesList = implode(', ', (array) $designTypeNames);
            }

            $images = $this->timed('gallery.images', fn () => $model->getGalleryImages($entry));
            $winnerLevelName = ((int) ($details['winner_level'] ?? 0) > 0)
                ? $model->getWinnerLevel((int) $details['winner_level'])
                : '';

            $backLink = ($search !== '')
                ? site_url('gallery?search=' . urlencode($search))
                : $this->buildCompUrl($year, $activeCompContext);

            $metaDescription = trim((string) ($details['short_description'] ?: $details['full_description']));
            $metaDescription = mb_substr(strip_tags($metaDescription), 0, 160);

            $data['entry']           = $entry;
            $data['year']            = $year;
            $data['comp']            = $activeCompContext;
            $data['details']         = $details;
            $data['images']          = $images;
            $data['certificate']     = $model->getGalleryCertificate($entry);
            $data['compDetails']     = $compDetails;
            $data['designTypesList'] = $designTypesList;
            $data['isWinnerContext'] = $isWinnerContext;
            $data['youtubeEmbedId']  = $this->extractYoutubeEmbedId((string) ($details['youtube_url'] ?? ''));
            $data['winnerLevelName'] = $winnerLevelName;
            $data['backLink']        = $backLink;
            $data['metaTitle']       = trim((string) $details['design_name']) . ' | Spark Awards Galleries';
            $data['metaDescription'] = $metaDescription !== '' ? $metaDescription : $data['metaDescription'];
            $data['canonicalUrl']    = $this->buildEntryUrl($year, $activeCompContext, $entry);
            $data['ogImage']         = $images[0]['entry_photo'] ?? null;
        } elseif ($search !== '') {
            $rawResults = $this->cachedValue(
                'gallery:search:' . md5(strtolower($search)),
                fn () => $this->timed('gallery.search', fn () => $model->gallerySearch($search)),
                self::CACHE_TTL_SHORT
            );
            $results = [];

            $compMap = $model->getCompetitionsByIDs(array_map('intval', array_column((array) $rawResults, 'comp_id')));

            foreach ((array) $rawResults as $row) {
                $compId = (int) ($row['comp_id'] ?? 0);
                $competition = $compMap[$compId] ?? [];
                if ($competition === []) {
                    continue;
                }

                $results[] = [
                    'entry_id'        => $row['entry_id'],
                    'design_name'     => $row['design_name'],
                    'comp_year'       => $competition['comp_year'] ?? '',
                    'comp_type_name'  => $competition['comp_type_name'] ?? '',
                    'link'            => $this->buildEntryUrl(
                        (int) $competition['comp_year'],
                        (string) $competition['comp_id'],
                        (string) $row['entry_id'],
                        ['search' => $search]
                    ),
                ];
            }

            $data['results']         = $results;
            $data['metaTitle']       = 'Gallery Search | Spark Awards';
            $data['metaDescription'] = 'Search Spark Awards entries by design, company, or description.';
            $data['canonicalUrl']    = site_url('gallery?search=' . urlencode($search));
        } else {
            $tiles      = [];
            $typeLabel  = null;
            if ($comp !== '') {
                $isWinnerScope = ($comp === 'Winners');

                if ($isWinnerScope) {
                    $records = $this->cachedValue(
                        "gallery:winners:{$year}",
                        fn () => $this->timed('gallery.winners', fn () => $model->getGalleryWinners((string) $year)),
                        self::CACHE_TTL_MEDIUM
                    );
                    $typeLabel = "{$year} Winners";
                } else {
                    $competition = $this->cachedValue(
                        "gallery:comp:{$comp}",
                        fn () => $this->timed('gallery.compById', fn () => $model->getCompByID((int) $comp)),
                        self::CACHE_TTL_MEDIUM
                    );
                    if (! is_array($competition) || $competition === []) {
                        throw PageNotFoundException::forPageNotFound("Competition not found: {$comp}");
                    }

                    $records = $this->cachedValue(
                        "gallery:entries:{$year}:{$competition['comp_type_id']}",
                        fn () => $this->timed('gallery.entries', fn () => $model->getGalleryEntries((string) $year, (string) $competition['comp_type_id'])),
                        self::CACHE_TTL_MEDIUM
                    );
                    $typeLabel = "{$year} Spark: " . ($competition['comp_type_name'] ?? '');
                }

                foreach ((array) $records as $record) {
                    $images = $model->getTopGalleryImages((string) $record['entry_id']);
                    if ($images === []) {
                        continue;
                    }

                    $tileComp = $isWinnerScope ? 'Winners' : (string) $record['comp_id'];
                    $tiles[]  = [
                        'label'    => $record['design_name'] ?? ('Entry #' . $record['entry_id']),
                        'photo'    => $images[0]['entry_photo'] ?? '',
                        'year'     => $year,
                        'comp_id'  => $tileComp,
                        'isWinner' => $isWinnerScope,
                        'link'     => $this->buildEntryUrl($year, $tileComp, (string) $record['entry_id']),
                    ];
                }

                $data['metaTitle']       = ($typeLabel ?: 'Gallery') . ' | Spark Awards';
                $data['metaDescription'] = 'Browse Spark Awards entries and winners.';
                $data['canonicalUrl']    = $this->buildCompUrl($year, $comp);
            } else {
                $gridRows = $this->cachedValue(
                    "gallery:grid:{$year}",
                    fn () => $this->timed('gallery.grid', fn () => $model->getGalleryGrid((string) $year)),
                    self::CACHE_TTL_MEDIUM
                );

                $winnerRows = $this->cachedValue(
                    "gallery:winners:{$year}",
                    fn () => $this->timed('gallery.winners', fn () => $model->getGalleryWinners((string) $year)),
                    self::CACHE_TTL_MEDIUM
                );

                if ($winnerRows !== []) {
                    $winner = $winnerRows[array_rand($winnerRows)];
                    $photo  = $model->getTopGalleryImages((string) $winner['entry_id'])[0]['entry_photo'] ?? '';

                    if ($photo !== '') {
                        $tiles[] = [
                            'label'    => "{$year} Winners",
                            'photo'    => $photo,
                            'year'     => $year,
                            'comp_id'  => 'Winners',
                            'isWinner' => true,
                            'link'     => $this->buildCompUrl($year, 'Winners'),
                        ];
                    }
                }

                foreach ((array) $gridRows as $row) {
                    $photos = $model->getRandomFeaturedPhotos((string) $row['comp_year'], (string) $row['comp_type_id']);
                    if ($photos === []) {
                        $photos = $model->getRandomPhotos((string) $row['comp_year'], (string) $row['comp_type_id']);
                    }

                    if ($photos === []) {
                        continue;
                    }

                    $tiles[] = [
                        'label'    => "{$row['comp_year']} Spark: {$row['comp_type_name']}",
                        'photo'    => $photos[array_rand($photos)]['entry_photo'],
                        'year'     => (int) $row['comp_year'],
                        'comp_id'  => (string) $row['comp_id'],
                        'isWinner' => false,
                        'link'     => $this->buildCompUrl((int) $row['comp_year'], (string) $row['comp_id']),
                    ];
                }

                $data['metaTitle']    = "{$year} Galleries | Spark Awards";
                $data['canonicalUrl'] = site_url('gallery?year=' . $year);
            }

            $data['tiles']      = $tiles;
            $data['typeLabel']  = $typeLabel;
        }

        return view('gallery/index', $data);
    }

    private function normalizeEntry(?string $entry): ?string
    {
        if ($entry === null) {
            return null;
        }

        $entry = trim($entry);
        if ($entry === '') {
            return null;
        }

        if (preg_match('/^[A-Za-z0-9-]{1,64}$/', $entry) === 1) {
            return $entry;
        }

        return null;
    }

    private function normalizeYear(mixed $year): ?int
    {
        if ($year === null || $year === '') {
            return null;
        }

        $value = (int) $year;
        if ($value < 2007 || $value > ((int) date('Y') + 1)) {
            return null;
        }

        return $value;
    }

    private function normalizeComp(mixed $comp): string
    {
        if ($comp === null) {
            return '';
        }

        $comp = trim((string) $comp);
        if ($comp === 'Winners') {
            return 'Winners';
        }

        return ctype_digit($comp) ? $comp : '';
    }

    private function buildCompUrl(int $year, string $comp, array $extraQuery = []): string
    {
        $query = ['year' => $year];
        if ($comp !== '') {
            $query['comp'] = $comp;
        }

        foreach ($extraQuery as $key => $value) {
            $query[(string) $key] = (string) $value;
        }

        return site_url('gallery?' . http_build_query($query));
    }

    private function buildEntryUrl(int $year, string $comp, string $entryId, array $extraQuery = []): string
    {
        $query = [
            'year'  => $year,
            'comp'  => $comp,
            'entry' => $entryId,
        ];

        foreach ($extraQuery as $key => $value) {
            $query[(string) $key] = (string) $value;
        }

        return site_url('gallery?' . http_build_query($query));
    }

    private function extractYoutubeEmbedId(string $urlOrId): ?string
    {
        $value = trim($urlOrId);
        if ($value === '') {
            return null;
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $value) === 1) {
            return $value;
        }

        $parts = parse_url($value);
        if (! is_array($parts)) {
            return null;
        }

        if (! empty($parts['query'])) {
            parse_str($parts['query'], $query);
            $videoId = $query['v'] ?? null;
            if (is_string($videoId) && preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId) === 1) {
                return $videoId;
            }
        }

        if (! empty($parts['path'])) {
            $path = trim($parts['path'], '/');
            $path = str_starts_with($path, 'embed/') ? substr($path, 6) : $path;
            if (preg_match('/^[A-Za-z0-9_-]{11}$/', $path) === 1) {
                return $path;
            }
        }

        return null;
    }

    private function timed(string $label, callable $callback): mixed
    {
        $start = microtime(true);
        $result = $callback();
        $elapsedMs = (microtime(true) - $start) * 1000;

        if ($elapsedMs >= 350) {
            log_message('warning', 'Slow gallery operation {label}: {ms}ms', [
                'label' => $label,
                'ms'    => number_format($elapsedMs, 2),
            ]);
        }

        return $result;
    }

    private function cachedValue(string $cacheKey, callable $callback, int $ttl): mixed
    {
        $cache = cache();
        if ($cache === null) {
            return $callback();
        }

        $safeKey = $this->safeCacheKey($cacheKey);

        $cached = $cache->get($safeKey);
        if ($cached !== null) {
            return $cached;
        }

        $value = $callback();
        $cache->save($safeKey, $value, $ttl);

        return $value;
    }

    private function safeCacheKey(string $rawKey): string
    {
        // Keep cache keys portable across handlers and reserved-character settings.
        return 'gallery_' . md5($rawKey);
    }
}
