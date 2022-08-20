<?php

/**
 * author : Reza Dehghani with freecodecamp.org course
 * 
 */

use app\controllers\AuthController;
use app\controllers\SiteController;
use Dotenv\Dotenv;
use app\controllers\PanelController;
use app\core\Application;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config =   [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
    ];

$app = new Application(dirname(__DIR__), $config);

// Site controller: Front-end
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);
$app->router->get('/products', [SiteController::class, 'products']);
$app->router->post('/products', [SiteController::class, 'products']);
$app->router->get('/shopcart', [SiteController::class, 'shopCart']);
$app->router->post('/shopcart', [SiteController::class, 'shopCart']);

// User Authenticate : Back-end
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

//Product managment : Back-end
$app->router->get('/panel', [PanelController::class, 'dashboard']);
$app->router->get('/panel/addProduct', [PanelController::class, 'addProduct']);
$app->router->post('/panel/addProduct', [PanelController::class, 'addProduct']);
$app->router->get('/panel/productCategory', [PanelController::class, 'productCategory']);
$app->router->post('/panel/productCategory', [PanelController::class, 'productCategory']);
$app->router->get('/panel/discount', [PanelController::class, 'productDiscount']);
$app->router->post('/panel/discount', [PanelController::class, 'productDiscount']);
$app->router->get('/panel/attribute', [PanelController::class, 'productAttribute']);
$app->router->post('/panel/attribute', [PanelController::class, 'productAttribute']);


$app->run();