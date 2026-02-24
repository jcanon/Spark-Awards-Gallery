<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class GalleryVisualContractTest extends CIUnitTestCase
{
    public function testGalleryCssContainsCriticalCardLayoutRules(): void
    {
        $css = file_get_contents(FCPATH . 'css/gallery.css');

        $this->assertIsString($css);
        $this->assertStringContainsString('.gallery-card-title-wrap', $css);
        $this->assertStringContainsString('overflow-wrap: anywhere', $css);
        $this->assertStringContainsString('-webkit-line-clamp: 2', $css);
    }

    public function testGalleryCssContainsCriticalModalRules(): void
    {
        $css = file_get_contents(FCPATH . 'css/gallery.css');

        $this->assertIsString($css);
        $this->assertStringContainsString('#colorbox.cbox-modern #cboxClose', $css);
        $this->assertStringContainsString('#colorbox.cbox-gallery #cboxPrevious', $css);
        $this->assertStringContainsString('#colorbox.cbox-gallery #cboxNext', $css);
        $this->assertStringContainsString('#colorbox.cbox-certificate #cboxPrevious', $css);
    }

    public function testGalleryUiScriptContainsInfiniteScrollAndModalInit(): void
    {
        $js = file_get_contents(FCPATH . 'js/gallery-ui.js');

        $this->assertIsString($js);
        $this->assertStringContainsString('initInfiniteScroll', $js);
        $this->assertStringContainsString('IntersectionObserver', $js);
        $this->assertStringContainsString("$('a.gallery').colorbox", $js);
        $this->assertStringContainsString("$('a.certificate-pdf-popup').colorbox", $js);
    }
}
