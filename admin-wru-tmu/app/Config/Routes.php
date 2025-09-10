<?php
// app/Config/Routes.php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/testdb', 'Auth::testdb');
$routes->get('/testpromag', 'Auth::testPromag');

// Auth Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->post('/auth/updateProfile', 'Auth::updateProfile');
    $routes->post('/auth/changePassword', 'Auth::changePassword');
    $routes->get('logout', 'Auth::logout');
});

// Dashboard Routes
$routes->get('dashboard', 'Dashboard::index');
$routes->get('profile', 'Dashboard::profile');
$routes->post('profile/update', 'Dashboard::updateProfile');
$routes->post('profile/changePassword', 'Dashboard::changePassword');

// People Routes
// Routes for People management
$routes->group('people', function ($routes) {
    $routes->get('/', 'People::index');
    $routes->get('debug', 'People::debug'); // Debug route
    $routes->post('create', 'People::create');
    $routes->post('update', 'People::update');
    $routes->get('delete/(:num)', 'People::delete/$1');
    $routes->get('deleteSimple/(:num)', 'People::deleteSimple/$1'); // Simple delete route
    
    // AJAX routes for tmp_people
    $routes->post('addTmp', 'People::addTmp');
    $routes->delete('removeTmp/(:num)', 'People::removeTmp/$1');
    $routes->post('savePeople', 'People::savePeople');
    $routes->post('addQuick', 'People::addQuick'); // Add quick person via AJAX
    $routes->get('getAll', 'People::getAll'); // Get all people via AJAX
    
    // Utility route
    $routes->post('clearTmp', 'People::clearTmp');
});

// Destinations Routes
$routes->group('destinations', function($routes) {
    $routes->get('/', 'Destinations::index');
    $routes->get('create', 'Destinations::create');
    $routes->post('store', 'Destinations::store');
    $routes->get('edit/(:num)', 'Destinations::edit/$1');
    $routes->post('update/(:num)', 'Destinations::update/$1');
    $routes->post('update', 'Destinations::updateSingle'); // Add this for modal edit
    $routes->get('delete/(:num)', 'Destinations::delete/$1');
    $routes->get('deleteWithoutCascade/(:num)', 'Destinations::deleteWithoutCascade/$1'); // Delete without cascade
    $routes->get('debugDelete/(:num)', 'Destinations::debugDelete/$1'); // Debug route
    $routes->get('testSoftDelete/(:num)', 'Destinations::testSoftDelete/$1'); // Test route
    $routes->get('createTestDestination', 'Destinations::createTestDestination'); // Create test

    $routes->post('addTmp', 'Destinations::addTmp');
    $routes->delete('removeTmp/(:num)', 'Destinations::removeTmp/$1');
    $routes->post('saveDestinations', 'Destinations::saveDestinations');
    $routes->post('addQuick', 'Destinations::addQuick'); // Add quick destination via AJAX
    $routes->get('getAll', 'Destinations::getAll'); // Get all destinations via AJAX
    
    // Utility route
    $routes->post('clearTmp', 'Destinations::clearTmp');
});

// Vehicles Routes
$routes->group('vehicles', function($routes) {
    $routes->get('/', 'Vehicles::index');
    $routes->get('create', 'Vehicles::create');
    $routes->post('store', 'Vehicles::store');
    $routes->get('edit/(:num)', 'Vehicles::edit/$1');
    $routes->post('update/(:num)', 'Vehicles::update/$1');
    $routes->post('update', 'Vehicles::updateSingle'); // Add this for modal edit
    $routes->get('delete/(:num)', 'Vehicles::delete/$1');
    $routes->get('deleteWithoutCascade/(:num)', 'Vehicles::deleteWithoutCascade/$1'); // Delete without cascade
    $routes->get('debugDelete/(:num)', 'Vehicles::debugDelete/$1'); // Debug route
    $routes->get('createTestVehicle', 'Vehicles::createTestVehicle'); // Create test vehicle

     $routes->post('addTmp', 'Vehicles::addTmp');
    $routes->delete('removeTmp/(:num)', 'Vehicles::removeTmp/$1');
    $routes->post('saveVehicles', 'Vehicles::saveVehicles');
    $routes->post('addQuick', 'Vehicles::addQuick'); // Add quick vehicle via AJAX
    
    // Utility route
    $routes->post('clearTmp', 'Vehicles::clearTmp');
});

// M-Loc Routes
$routes->group('mloc', function ($routes) {
    $routes->get('/', 'MLoc::index');
    $routes->get('create', 'MLoc::create');
    
    // AJAX endpoints for form submission
    $routes->post('store', 'MLoc::store');
    $routes->post('storeMultiple', 'MLoc::storeMultiple');
    $routes->post('update', 'MLoc::update');
    $routes->post('delete', 'MLoc::delete');
    $routes->post('deleteSimple', 'MLoc::deleteSimple');
    
    // Flash message endpoints (for page refresh scenarios)
    $routes->post('storeWithFlash', 'MLoc::storeWithFlash');
    $routes->post('updateWithFlash', 'MLoc::updateWithFlash');
    $routes->post('deleteWithFlash', 'MLoc::deleteWithFlash');
    $routes->get('deleteWithFlash/(:num)', 'MLoc::deleteWithFlash/$1');
    
    // Delete all schedules endpoints
    $routes->post('deleteAllByPerson', 'MLoc::deleteAllByPerson');
    $routes->post('deleteAllByPersonWithFlash', 'MLoc::deleteAllByPersonWithFlash');
    
    // Data retrieval endpoints
    $routes->get('getData/(:num)', 'MLoc::getData/$1');
    $routes->post('checkConflict', 'MLoc::checkConflict');
    
    // Temporary data handling for multiple mode
    $routes->get('getTempData', 'MLoc::getTempData');
    $routes->post('addToTempData', 'MLoc::addToTempData');
    $routes->post('editTempData/(:num)', 'MLoc::editTempData/$1');
    $routes->delete('deleteTempData/(:num)', 'MLoc::deleteTempData/$1');
    $routes->post('saveAllTempData', 'MLoc::saveAllTempData');
    $routes->post('clearAllTempData', 'MLoc::clearAllTempData');
    
    // Legacy temporary data handling (if still needed)
    $routes->post('addTmp', 'Mloc::addTmp');
    $routes->get('getTmpMloc', 'Mloc::getTmpMloc');
    $routes->delete('removeTmp/(:num)', 'Mloc::removeTmp/$1');
    $routes->post('saveMloc', 'Mloc::saveMloc');
    
    // Edit temporary data routes
    $routes->get('edit-temp/(:num)', 'Mloc::editTemp/$1');
    $routes->post('update-temp/(:num)', 'Mloc::updateTemp/$1');
    $routes->delete('delete-temp/(:num)', 'Mloc::deleteTemp/$1');
    $routes->post('save-all', 'Mloc::saveAll');
    $routes->post('clear-temp', 'Mloc::clearTemp');
    
    // Individual record operations
    $routes->get('edit/(:num)', 'MLoc::edit/$1');
    $routes->post('update/(:num)', 'MLoc::update/$1');
    $routes->delete('delete/(:num)', 'MLoc::delete/$1');
    $routes->post('deleteSimple/(:num)', 'MLoc::deleteSimple/$1');
});
// V-trip Routes
$routes->group('vtrip', function($routes) {
    $routes->get('/', 'VTrip::index');
    $routes->get('create', 'VTrip::create');
    $routes->post('addToTemp', 'VTrip::addToTemp');
    $routes->post('store', 'VTrip::store');                    // Add this for single data entry
    $routes->post('storeMultiple', 'VTrip::storeMultiple');    // Add this for multiple data entry
    $routes->post('update', 'VTrip::update');                // Add this for single data update
    $routes->post('updateMultiple', 'VTrip::updateMultiple'); // Add this for multiple data update
    $routes->post('delete', 'VTrip::delete');                // Add this for single data deletion
    
    // Conflict checking endpoint
    $routes->post('checkVehicleConflict', 'VTrip::checkVehicleConflict');
    
    // Flash message endpoints (for page refresh scenarios)
    $routes->post('storeWithFlash', 'VTrip::storeWithFlash');
    $routes->post('updateWithFlash', 'VTrip::updateWithFlash');
    $routes->post('deleteWithFlash', 'VTrip::deleteWithFlash');
    $routes->get('deleteWithFlash/(:num)', 'VTrip::deleteWithFlash/$1');
    
    // Delete all trips endpoints
    $routes->post('deleteAllByVehicle', 'VTrip::deleteAllByVehicle');
    $routes->post('deleteAllByVehicleWithFlash', 'VTrip::deleteAllByVehicleWithFlash');
    
    // Temporary data handling for multiple mode
    $routes->get('getTempData', 'VTrip::getTempData');
    $routes->post('addToTempData', 'VTrip::addToTempData');
    $routes->post('editTempData/(:num)', 'VTrip::editTempData/$1');
    $routes->delete('deleteTempData/(:num)', 'VTrip::deleteTempData/$1');
    $routes->post('saveAllTempData', 'VTrip::saveAllTempData');
    $routes->post('clearAllTempData', 'VTrip::clearAllTempData');
    
    // Legacy temporary routes (if still needed)
    $routes->get('editTemp/(:num)', 'VTrip::editTemp/$1');
    $routes->put('updateTemp/(:num)', 'VTrip::updateTemp/$1');
    $routes->delete('deleteTemp/(:num)', 'VTrip::deleteTemp/$1');
    $routes->post('saveAll', 'VTrip::saveAll');
    $routes->post('clearTemp', 'VTrip::clearTemp');
    $routes->get('edit/(:num)', 'VTrip::edit/$1');
    $routes->put('update/(:num)', 'VTrip::update/$1');
    $routes->delete('delete/(:num)', 'VTrip::delete/$1');
});

// History Routes
$routes->group('history', function($routes) {
    $routes->get('/', 'History::index');
    $routes->get('mloc', 'History::mloc');
    $routes->get('vtrip', 'History::vtrip');
});