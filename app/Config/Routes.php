<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('whatsapp/qr', 'Whatsapp::getQR');
$routes->get('whatsapp/scanqr', 'WhatsApp::showQR');
$routes->get('whatsapp/checkserver', 'WhatsApp::checkserv');
$routes->get('whatsapp/retry', 'WhatsApp::retryQR');
