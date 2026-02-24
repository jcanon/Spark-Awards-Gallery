<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class GalleryFrontendSmokeTest extends CIUnitTestCase
{
    public function testFooterLoadsGalleryUiBundle(): void
    {
        $footer = file_get_contents(APPPATH . 'Views/partials/footer.php');

        $this->assertIsString($footer);
        $this->assertStringContainsString("base_url('js/gallery-ui.js')", $footer);
    }

    public function testGridContainsInfiniteScrollHooks(): void
    {
        $grid = file_get_contents(APPPATH . 'Views/gallery/grid.php');

        $this->assertIsString($grid);
        $this->assertStringContainsString('js-infinite-item', $grid);
        $this->assertStringContainsString('gallery-infinite-sentinel', $grid);
    }

    public function testDetailsContainsModalHooks(): void
    {
        $details = file_get_contents(APPPATH . 'Views/gallery/details.php');

        $this->assertIsString($details);
        $this->assertStringContainsString('class="gallery"', $details);
        $this->assertStringContainsString('certificate-pdf-popup', $details);
    }
}
