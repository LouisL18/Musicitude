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
use app\Factories\PlaylistFactory;
use app\Controllers\PlaylistController;

$albumController = new AlbumController(new AlbumFactory(DatabaseProvider::getDataBase()), new ArtistFactory(DatabaseProvider::getDataBase()), new UserFactory(DatabaseProvider::getDataBase()), new PlaylistFactory(DatabaseProvider::getDataBase()));
$artistController = new ArtistController(new ArtistFactory(DatabaseProvider::getDataBase()), new AlbumFactory(DatabaseProvider::getDataBase()), new UserFactory(DatabaseProvider::getDataBase()));
$userController = new UserController(new UserFactory(DatabaseProvider::getDataBase()), new ArtistFactory(DatabaseProvider::getDataBase()));
$playlistController = new PlaylistController(new PlaylistFactory(DatabaseProvider::getDataBase()), new UserFactory(DatabaseProvider::getDataBase()), new AlbumFactory(DatabaseProvider::getDataBase()), new ArtistFactory(DatabaseProvider::getDataBase()));

$router = new Router();

$router->get('/', [$albumController, 'index']);
$router->get('/login', [$userController, 'login']);
$router->get('/logout', [$userController, 'logout']);
$router->get('/register', [$userController, 'register']);
$router->get('/albums', [$albumController, 'index']);
$router->get('/album/{id}', [$albumController, 'detail']);
$router->get('/artists', [$artistController, 'index']);
$router->get('/artist/{id}', [$artistController, 'detail']);
$router->get('/user', [$userController, 'profile']);
$router->get('/albums/search', [$albumController, 'search']);
$router->get('/album/{id}/edit', [$albumController, 'edit']);
$router->get('/album/create', [$albumController, 'create']);
$router->get('/playlists', [$playlistController, 'index']);
$router->get('/playlist/{id}', [$playlistController, 'detail']);
$router->get('/playlist/create', [$playlistController, 'create']);
$router->get('/playlist/{id}/edit', [$playlistController, 'edit']);
$router->get('/user/edit', [$userController, 'edit']);

$router->put('/album/{id}', [$albumController, 'update']);
$router->put('/artist/{id}', [$artistController, 'update']);
$router->put('/user/{id}', [$userController, 'update']);
$router->put('/playlist/{id}/add/{id}', [$playlistController, 'add']);

$router->delete('/album/{id}', [$albumController, 'delete']);
$router->delete('/artist/{id}', [$artistController, 'delete']);
$router->delete('/user', [$userController, 'delete']);
$router->delete('/playlist/{id}/remove/{id}', [$playlistController, 'remove']);
$router->delete('/playlist/{id}/delete', [$playlistController, 'delete']);
$router->delete('/musique/{id}', [$albumController, 'deleteMusic']);

$router->post('/login', [$userController, 'login']);
$router->post('/album/create', [$albumController, 'create']);
$router->post('/artist', [$artistController, 'create']);
$router->post('/user', [$userController, 'create']);
//$router->post('/logout', [$userController, 'logout']);
$router->post('/register', [$userController, 'register']);
$router->post('/albums/search', [$albumController, 'search']);
$router->post('/albums', [$albumController, 'index']);
$router->post('/album/{id}', [$albumController, 'detail']);
$router->post('/playlist/create', [$playlistController, 'create']);
$router->post('/playlist/{id}/edit', [$playlistController, 'edit']);
$router->post('/album/{id}/note/{id}', [$albumController, 'rate']);
$router->post('/album/{id}/edit', [$albumController, 'edit']);
$router->post('/user/edit', [$userController, 'edit']);

$router->run();
