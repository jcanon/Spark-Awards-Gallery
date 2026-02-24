<?php

use App\Controllers\GalleryController;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class GalleryControllerTest extends CIUnitTestCase
{
    public function testNormalizeEntryAcceptsUuidAndNumeric(): void
    {
        $controller = new GalleryController();

        $method = new ReflectionMethod($controller, 'normalizeEntry');
        $method->setAccessible(true);

        $uuid = 'F7DE3BB5-C022-4872-FE8FC408F854DB02';

        $this->assertSame($uuid, $method->invoke($controller, $uuid));
        $this->assertSame('12345', $method->invoke($controller, '12345'));
        $this->assertNull($method->invoke($controller, '<script>alert(1)</script>'));
    }

    public function testWinnerEntryUrlKeepsWinnerContext(): void
    {
        $controller = new GalleryController();

        $method = new ReflectionMethod($controller, 'buildEntryUrl');
        $method->setAccessible(true);

        $url = $method->invoke($controller, 2024, 'Winners', 'F7DE3BB5-C022-4872-FE8FC408F854DB02');

        $this->assertStringContainsString('year=2024', $url);
        $this->assertStringContainsString('comp=Winners', $url);
        $this->assertStringContainsString('entry=F7DE3BB5-C022-4872-FE8FC408F854DB02', $url);
    }

    public function testCompUrlSupportsPagination(): void
    {
        $controller = new GalleryController();

        $method = new ReflectionMethod($controller, 'buildCompUrl');
        $method->setAccessible(true);

        $url = $method->invoke($controller, 2024, 'Winners', ['page' => 2]);

        $this->assertStringContainsString('year=2024', $url);
        $this->assertStringContainsString('comp=Winners', $url);
        $this->assertStringContainsString('page=2', $url);
    }
}
