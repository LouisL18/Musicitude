<?php
namespace provider;

require_once 'Autoloader.php';
Autoloader::register();

use app\Router;
use provider\DatabaseProvider;
use app\Factories\AlbumFactory;
use app\Controllers\AlbumController;
use app\Factories\ArtistFactory;
use app\Controllers\ArtistController;
use app\Factories\UserFactory;
use app\Controllers\UserController;

$albumController = new AlbumController(new AlbumFactory(DatabaseProvider::getDataBase()));
$artistController = new ArtistController(new ArtistFactory(DatabaseProvider::getDataBase()));
$userController = new UserController(new UserFactory(DatabaseProvider::getDataBase()));

$router = new Router();

$router->get('/', [$userController, 'login']);
$router->post('/login', [$userController, 'login']);
$router->get('/register', [$userController, 'register']);
$router->get('/albums', [$albumController, 'index']);
$router->get('/album/{id}', [$albumController, 'detail']);
$router->get('/artists', [$artistController, 'index']);
$router->get('/artist/{id}', [$artistController, 'detail']);
$router->get('/user', [$userController, 'index']);
$router->get('/albums/search', [$albumController, 'search']);

$router->put('/album/{id}', [$albumController, 'update']);
$router->put('/artist/{id}', [$artistController, 'update']);
$router->put('/user/{id}', [$userController, 'update']);

$router->delete('/album/{id}', [$albumController, 'delete']);
$router->delete('/artist/{id}', [$artistController, 'delete']);
$router->delete('/user/{id}', [$userController, 'delete']);

$router->post('/album', [$albumController, 'create']);
$router->post('/artist', [$artistController, 'create']);
$router->post('/user', [$userController, 'create']);
$router->post('/logout', [$userController, 'logout']);
$router->post('/login', [$userController, 'login']);
$router->post('/register', [$userController, 'register']);

$router->run();