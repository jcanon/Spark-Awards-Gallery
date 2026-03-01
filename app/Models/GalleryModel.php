<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $DBGroup      = 'default';
    protected $table        = 'comp_competitions';
    protected $primaryKey   = 'comp_id';
    protected $returnType   = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = []; // Query Builder is used directly.

    public function getGalleryGrid(string $galleryYear): array
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.comp_type_name')
            ->join('comp_type b', 'a.comp_type_id = b.comp_type_id')
            ->where('a.comp_phase_1_open <=', date('Y-m-d H:i:s'))
            ->where('a.comp_year', $galleryYear)
            ->orderBy('a.comp_year', 'DESC')
            ->orderBy('b.comp_type_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getGalleryEntries(string $galleryYear, string $galleryType): array
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.*, c.comp_type_name, d.*')
            ->join('comp_entries b', 'a.comp_id = b.comp_id')
            ->join('comp_type c', 'a.comp_type_id = c.comp_type_id')
            ->join('comp_users d', 'b.user_id = d.user_id')
            ->where('a.comp_year', $galleryYear)
            ->where('a.comp_type_id', $galleryType)
            ->where('b.entry_status !=', 'Draft')
            ->where('b.gallery_hide', 'No')
            ->orderBy('b.design_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getGalleryWinners(string $galleryYear): array
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.*, c.comp_type_name, d.*')
            ->join('comp_entries b', 'a.comp_id = b.comp_id')
            ->join('comp_type c', 'a.comp_type_id = c.comp_type_id')
            ->join('comp_users d', 'b.user_id = d.user_id')
            ->where('a.comp_year', $galleryYear)
            ->groupStart()
            ->where('b.entry_status', 'Winner')
            ->orWhere('b.winner_level >', 0)
            ->groupEnd()
            ->where('b.entry_status !=', 'Draft')
            ->where('b.gallery_hide', 'No')
            ->orderBy('b.design_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getGalleryDetails(string $entryID): array
    {
        return $this->db
            ->table('comp_entries a')
            ->select('a.*, b.*')
            ->join('comp_users b', 'a.user_id = b.user_id')
            ->where('a.entry_id', $entryID)
            ->get()
            ->getRowArray() ?? [];
    }

    public function getTopGalleryImages(string $entryID): array
    {
        return $this->db
            ->table('comp_entry_photos')
            ->where('entry_id', $entryID)
            ->where('entry_photo_res', 'Low')
            ->where('entry_photo_order', 1)
            ->get()
            ->getResultArray();
    }

    public function getGalleryImages(string $entryID): array
    {
        return $this->db
            ->table('comp_entry_photos a')
            ->select('a.*')
            ->join('comp_entries b', 'a.entry_id = b.entry_id')
            ->where('b.entry_id', $entryID)
            ->where('a.entry_photo_res', 'Low')
            ->orderBy('a.entry_photo_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getGalleryCertificate(string $entryID): array
    {
        return $this->db
            ->table('comp_entry_photos a')
            ->select('a.*')
            ->join('comp_entries b', 'a.entry_id = b.entry_id')
            ->where('b.entry_id', $entryID)
            ->where('a.entry_photo_res', 'PDF')
            ->orderBy('a.entry_photo_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getGalleryBadges(string $entryID): array
    {
        return $this->db
            ->table('comp_entry_photos a')
            ->select('a.*')
            ->join('comp_entries b', 'a.entry_id = b.entry_id')
            ->where('b.entry_id', $entryID)
            ->where('a.entry_photo_res', 'Badge')
            ->orderBy('a.entry_photo_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    protected function randomPhotoBase(string $galleryYear, string $galleryType)
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.*, c.*')
            ->join('comp_entries b', 'a.comp_id = b.comp_id')
            ->join('comp_entry_photos c', 'b.entry_id = c.entry_id')
            ->where('a.comp_year', $galleryYear)
            ->where('a.comp_type_id', $galleryType)
            ->where('b.entry_status !=', 'Draft')
            ->where('c.entry_photo_res', 'Low')
            ->where('c.entry_photo_order', 1);
    }

    public function getRandomPhotos(string $galleryYear, string $galleryType): array
    {
        return $this->randomPhotoBase($galleryYear, $galleryType)
            ->orderBy('a.comp_year', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRandomFeaturedPhotos(string $galleryYear, string $galleryType): array
    {
        return $this->randomPhotoBase($galleryYear, $galleryType)
            ->join('comp_retail_item_user d', 'b.entry_id = d.entry_id')
            ->groupStart()
            ->where('d.retail_item_id', 4)
            ->orWhere('d.retail_item_id', 7)
            ->groupEnd()
            ->orderBy('a.comp_year', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getCompByID(int $compID): array
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.comp_type_name')
            ->join('comp_type b', 'a.comp_type_id = b.comp_type_id')
            ->where('a.comp_id', $compID)
            ->get()
            ->getRowArray() ?? [];
    }

    /**
     * Returns competition rows indexed by comp_id.
     *
     * @param list<int> $compIDs
     * @return array<int, array<string, mixed>>
     */
    public function getCompetitionsByIDs(array $compIDs): array
    {
        $compIDs = array_values(array_unique(array_filter(array_map('intval', $compIDs))));
        if ($compIDs === []) {
            return [];
        }

        $rows = $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.comp_type_name')
            ->join('comp_type b', 'a.comp_type_id = b.comp_type_id')
            ->whereIn('a.comp_id', $compIDs)
            ->get()
            ->getResultArray();

        $indexed = [];
        foreach ($rows as $row) {
            $indexed[(int) $row['comp_id']] = $row;
        }

        return $indexed;
    }

    /**
     * @param list<int> $designTypeIDs
     * @return list<string>
     */
    public function getDesignTypeNamesByIDs(array $designTypeIDs): array
    {
        $designTypeIDs = array_values(array_unique(array_filter(array_map('intval', $designTypeIDs))));
        if ($designTypeIDs === []) {
            return [];
        }

        $rows = $this->db
            ->table('comp_design_types')
            ->select('design_type_name')
            ->whereIn('design_type_id', $designTypeIDs)
            ->orderBy('design_type_name', 'ASC')
            ->get()
            ->getResultArray();

        return array_values(array_column($rows, 'design_type_name'));
    }

    public function getWinnerLevel(int $winnerLevelID): string
    {
        $row = $this->db
            ->table('comp_winner_levels')
            ->select('winner_level_name')
            ->where('winner_level_id', $winnerLevelID)
            ->get()
            ->getRowArray();

        return $row['winner_level_name'] ?? '';
    }

    public function gallerySearch(string $search): array
    {
        return $this->db
            ->table('comp_entries a')
            ->select('a.*, b.*')
            ->join('comp_users b', 'a.user_id = b.user_id')
            ->groupStart()
            ->like('a.design_name', $search)
            ->orLike('a.short_description', $search)
            ->orLike('a.full_description', $search)
            ->orLike('b.company_name', $search)
            ->groupEnd()
            ->where('a.entry_status !=', 'Draft')
            ->where('a.gallery_hide', 'No')
            ->get()
            ->getResultArray();
    }
}
