<?php

// ===============================================================================================
// Remap Indonesia API v.1.1
// NOVEMBER 2017
// ===============================================================================================

// Set default timezone
date_default_timezone_set('Asia/Jakarta');

// Define remap base directory
define ( "QUEUE_BASE", dirname ( __FILE__ ) . "/" );

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Add the framework
// ===============================================================================================
require_once '../vendor/autoload.php';

// defining word
define ( "PHP", ".php", TRUE);
define ( "QUEUE", "App/System/Queue" . PHP, TRUE );
define ( "DATABASE", "App/System/Database" . PHP, TRUE );
define ( "CONFIG", "App/System/Config" . PHP, TRUE );
define ( "DEP", "App/System/Dependencies" . PHP, TRUE );
define ( "ROUTER", "App/System/Router" . PHP, TRUE );
define ( "MIDDLEWARE", "App/Middleware/Middleware" . PHP, TRUE );
define ( "CONTROLLER", "App/Controllers/", TRUE );

// Configure App
require_once ( CONFIG );

// Inisiate the Apps
// ===============================================================================================
$queue = new \Slim\App( $config );

// set Dependencies
// require_once ( DEP );

// Requiring Database Engine
require_once ( DATABASE );

// Requiring Remap Engine
require_once ( QUEUE );

// set Middleware
require_once ( MIDDLEWARE );

// set Routers
require_once ( ROUTER );

// ===============================================================================================
// CORS Setup
// ===============================================================================================
$queue->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response->withHeader('Access-Control-Allow-Origin', 'https://queue.id/')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// ===============================================================================================
// Run the App
// ===============================================================================================
$queue->run();

?>