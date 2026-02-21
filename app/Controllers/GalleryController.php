<?php
namespace App\Controllers;

use App\Models\GalleryModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class GalleryController extends Controller
{
    /**
     * Single entry point for grid, search, and details.
     *
     * @param string|null $entryFromUri
     */
    public function index($entryFromUri = null)
    {
        helper(['url', 'form']);
        $request = service('request');
        $model = new GalleryModel();

        // — POST → redirects for search/year forms
        if ($request->getMethod() === 'post') {
            if ($q = $request->getPost('gallerysearch', FILTER_SANITIZE_STRING)) {
                return redirect()->to(site_url("gallery?search=" . urlencode($q)));
            }
            if ($y = $request->getPost('submityear', FILTER_SANITIZE_NUMBER_INT)) {
                return redirect()->to(site_url("gallery?year=" . intval($y)));
            }
        }

        // — GET params (year, comp, search, entry)
        $entry = $entryFromUri
            ?: $request->getGet('entry', FILTER_SANITIZE_STRING);
        $search = $request->getGet('search', FILTER_SANITIZE_STRING) ?? '';
        $year = (int)($request->getGet('year', FILTER_SANITIZE_NUMBER_INT) ?? date('Y'));
        $comp = $request->getGet('comp', FILTER_SANITIZE_STRING) ?? '';

        // Base view data
        $data = compact('entry', 'search', 'year', 'comp');

        // — DETAILS BRANCH —
        if ($entry) {
            // 1) Get the entry details
            $details = $model->getGalleryDetails((string)$entry);
            if (empty($details)) {
                throw PageNotFoundException::forPageNotFound("Entry not found: {$entry}");
            }
            $data['details'] = $details;
            $data['images'] = $model->getGalleryImages((string)$entry);
            $data['certificate'] = $model->getGalleryCertificate((string)$entry);

            // 2) Design Types
            $designTypesList = '';
            if (!empty($details['design_type_list'])) {
                $ids = array_filter(explode(',', $details['design_type_list']));
                $names = $model->db
                    ->table('comp_design_types')
                    ->select('design_type_name')
                    ->whereIn('design_type_id', $ids)
                    ->orderBy('design_type_name', 'ASC')
                    ->get()
                    ->getResultArray();
                $designTypesList = implode(', ', array_column($names, 'design_type_name'));
            }
            $data['designTypesList'] = $designTypesList;

            // 3) Competition details (has comp_year & comp_type_id)
            $compDetails = $model->getCompByID((int)$details['comp_id']);
            $data['compDetails'] = $compDetails;

            // 4) Prev / Next: use compDetails, NOT $details
            $compYear = $compDetails['comp_year'];
            $compTypeId = $compDetails['comp_type_id'];
            $allEntries = $model->getGalleryEntries((string)$compYear, (string)$compTypeId);
            $ids = array_column($allEntries, 'entry_id');
            $pos = array_search($entry, $ids, true);

            $data['prevLink'] = ($pos > 0)
                ? site_url("gallery?year={$year}&entry=" . $ids[$pos - 1])
                : null;

            $data['nextLink'] = ($pos !== false && $pos < count($ids) - 1)
                ? site_url("gallery?year={$year}&entry=" . $ids[$pos + 1])
                : null;
        } // — SEARCH BRANCH —
        elseif ($search) {
            $raw = $model->gallerySearch($search);
            $results = [];
            foreach ($raw as $r) {
                $c = $model->getCompByID((int)$r['comp_id']);
                $results[] = [
                    'entry_id' => $r['entry_id'],
                    'design_name' => $r['design_name'],
                    'comp_year' => $c['comp_year'] ?? '',
                    'comp_type_name' => $c['comp_type_name'] ?? '',
                    'link' => site_url("gallery?year={$c['comp_year']}&entry={$r['entry_id']}"),
                ];
            }
            $data['results'] = $results;
        } // — GRID BRANCH —
        else {
            $tiles = [];
            $typeLabel = null;

            if ($comp) {
                $isWinner = ($comp === 'Winners');
                if ($isWinner) {
                    $records = $model->getGalleryWinners((string)$year);
                    $typeLabel = "{$year} Winners";
                } else {
                    $records = $model->getGalleryEntries((string)$year, (string)$comp);
                    $info = $model->getCompByID((int)$comp);
                    $typeLabel = "{$year} Spark: " . ($info['comp_type_name'] ?? '');
                }

                foreach ($records as $r) {
                    $imgs = $model->getTopGalleryImages((string)$r['entry_id']);
                    $tiles[] = [
                        'label' => $r['design_name'] ?? 'Entry #' . $r['entry_id'],
                        'photo' => $imgs[0]['entry_photo'] ?? '',
                        'year' => $year,
                        'comp_id' => $isWinner ? 'Winners' : $r['comp_id'],
                        'isWinner' => $isWinner,
                        'link' => $isWinner
                            ? site_url("gallery?year={$year}&comp=Winners")
                            : site_url("gallery?year={$year}&comp={$r['comp_id']}")
                    ];
                }
            } else {
                // default overview
                $grid = $model->getGalleryGrid((string)$year);

                // one winner tile first
                $winners = $model->getGalleryWinners((string)$year);
                if (!empty($winners)) {
                    $w = $winners[array_rand($winners)];
                    $tiles[] = [
                        'label' => "{$year} Winners",
                        'photo' => $model->getTopGalleryImages((string)$w['entry_id'])[0]['entry_photo'] ?? '',
                        'year' => $year,
                        'comp_id' => 'Winners',
                        'isWinner' => true,
                        'link' => site_url("gallery?year={$year}&comp=Winners")
                    ];
                }

                // competition-type tiles
                foreach ($grid as $r) {
                    $pics = $model->getRandomFeaturedPhotos((string)$r['comp_year'], (string)$r['comp_type_id'])
                        ?: $model->getRandomPhotos((string)$r['comp_year'], (string)$r['comp_type_id']);
                    if ($pics) {
                        $tiles[] = [
                            'label' => "{$r['comp_year']} Spark: {$r['comp_type_name']}",
                            'photo' => $pics[array_rand($pics)]['entry_photo'],
                            'year' => $r['comp_year'],
                            'comp_id' => $r['comp_id'],
                            'isWinner' => false,
                            'link' => site_url("gallery?year={$r['comp_year']}&comp={$r['comp_id']}")
                        ];
                    }
                }
            }

            $data['tiles'] = $tiles;
            $data['typeLabel'] = $typeLabel;
        }

        // render the unified wrapper
        return view('gallery/index', $data);
    }
}