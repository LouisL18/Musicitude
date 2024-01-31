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

#new router + get(route, [controller, method]) / post(...) / delete(...) -> run()