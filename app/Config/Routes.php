<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/profile', 'Profile::index');
$routes->get('/settings', 'Settings::index');

$routes->get('whatsapp/qr', 'Whatsapp::getQR');
$routes->get('whatsapp/scanqr', 'WhatsApp::showQR');
$routes->get('whatsapp/checkserver', 'WhatsApp::checkserv');
$routes->get('whatsapp/retry', 'WhatsApp::retryQR');
