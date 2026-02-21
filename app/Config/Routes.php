<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->match(['get','post'], 'gallery', 'GalleryController::index');
$routes->get('gallery/(:num)', 'GalleryController::index/$1');
$routes->get('/', 'GalleryController::index');
