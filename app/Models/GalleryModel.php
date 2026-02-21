<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'comp_competitions';
    protected $primaryKey = 'comp_id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = []; // we’re using the Query Builder directly

    /**
     * Get all competitions (grid) for a given year whose phase 1 is open.
     */
    public function getGalleryGrid(string $galleryYear)
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

    /**
     * Get all entries for a given year+type (excluding drafts/hidden).
     */
    public function getGalleryEntries(string $galleryYear, string $galleryType)
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

    /**
     * Get winners for a year.
     */
    public function getGalleryWinners(string $galleryYear)
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.*, c.comp_type_name, d.*')
            ->join('comp_entries b', 'a.comp_id = b.comp_id')
            ->join('comp_type c', 'a.comp_type_id = c.comp_type_id')
            ->join('comp_users d', 'b.user_id = d.user_id')
            ->where('a.comp_year', $galleryYear)
            ->where('b.entry_status', 'Winner')
            ->where('b.gallery_hide', 'No')
            ->orderBy('b.design_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get full details for a single entry.
     */
    public function getGalleryDetails(string $entryID)
    {
        return $this->db
            ->table('comp_entries a')
            ->select('a.*, b.*')
            ->join('comp_users b', 'a.user_id = b.user_id')
            ->where('a.entry_id', $entryID)
            ->get()
            ->getRowArray();
    }

    /**
     * Get the top (first) low-res photo for an entry.
     */
    public function getTopGalleryImages(string $entryID)
    {
        return $this->db
            ->table('comp_entry_photos')
            ->where('entry_id', $entryID)
            ->where('entry_photo_res', 'Low')
            ->where('entry_photo_order', 1)
            ->get()
            ->getResultArray();
    }

    /**
     * All low-res photos for an entry.
     */
    public function getGalleryImages(string $entryID)
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

    /**
     * PDF certificates for an entry.
     */
    public function getGalleryCertificate(string $entryID)
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

    /**
     * Random “featured” photos for entries of a given year/type.
     */
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

    public function getRandomPhotos(string $galleryYear, string $galleryType)
    {
        return $this->randomPhotoBase($galleryYear, $galleryType)
            ->orderBy('a.comp_year', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRandomFeaturedPhotos(string $galleryYear, string $galleryType)
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

    public function getRandomWinnerPhotos(string $galleryYear)
    {
        return $this->randomPhotoBase($galleryYear, '')
            ->where('b.entry_status', 'Winner')
            ->join('comp_retail_item_user d', 'b.entry_id = d.entry_id')
            ->groupStart()
            ->where('d.retail_item_id', 4)
            ->orWhere('d.retail_item_id', 7)
            ->groupEnd()
            ->orderBy('a.comp_year', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRandomFeaturedWinnerPhotos(string $galleryYear)
    {
        return $this->randomPhotoBase($galleryYear, '')
            ->where('b.entry_status', 'Winner')
            ->orderBy('a.comp_year', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get competition details by comp_id.
     */
    public function getCompByID(int $compID)
    {
        return $this->db
            ->table('comp_competitions a')
            ->select('a.*, b.comp_type_name')
            ->join('comp_type b', 'a.comp_type_id = b.comp_type_id')
            ->where('a.comp_id', $compID)
            ->get()
            ->getRowArray();
    }

    /**
     * Get a single comp_type_name.
     */
    public function getCompTypeByID(int $compTypeID): string
    {
        $row = $this->db
            ->table('comp_type')
            ->select('comp_type_name')
            ->where('comp_type_id', $compTypeID)
            ->get()
            ->getRowArray();

        return $row['comp_type_name'] ?? '';
    }

    /**
     * Get winner_level_name for a given level ID.
     */
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

    /**
     * Search across entries/users.
     */
    public function gallerySearch(string $search)
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