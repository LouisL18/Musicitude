<?php
namespace app\Controllers;

use app\Factories\AlbumFactory;
use app\Factories\ArtistFactory;
use app\Factories\UserFactory;

class AlbumController {
    protected $albumFactory;
    protected $artistFactory;
    protected $userFactory;

    public function __construct(AlbumFactory $albumFactory, ArtistFactory $artistFactory, UserFactory $userFactory) {
        $this->albumFactory = $albumFactory;
        $this->artistFactory = $artistFactory;
        $this->userFactory = $userFactory;
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $albums = $this->albumFactory->getAllAlbums();
            $super_albums = [];
            foreach($albums as $album) {
                $super_albums[] = [
                    'Album' => $album,
                    'Artiste' => $this->artistFactory->getArtistById($album->getIdArtiste()),
                    'Image' => $this->albumFactory->getImageById($album->getIdImage()),
                ];
            }
            global $main;
            global $css;
            $genres = $this->albumFactory->getAllGenres();
            $artists = $this->artistFactory->getAllArtists();
            $years = $this->albumFactory->getAllYears();
            $filters = $filters ?? ['search' => '', 'genre' => '', 'artist' => '', 'year' => ''];
            $main = require_once __DIR__ . '/../Views/album/index.php';
            $css = 'albums';
            require_once __DIR__ . '/../../public/index.php';
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albums = $this->albumFactory->getAllAlbums();
            $filters = ['search' => '', 'genre' => '', 'artist' => '', 'year' => ''];
            if (isset($_POST['search']) && $_POST['search'] != '') {
                $filters['search'] = $_POST['search'];
                $search = $_POST['search'];
                $albums = array_filter($albums, function($album) use ($search) {
                    return stripos($album->getNomAlbum(), $search) !== false;
                });
            }
            if (isset($_POST['genre']) && $_POST['genre'] != '') {
                $filters['genre'] = $_POST['genre'];
                $genre = intval($_POST['genre']);
                $albums = array_filter($albums, function($album) use ($genre) {
                    $album_genres = $this->albumFactory->getGenresByAlbum($album->getIdAlbum());
                    foreach ($album_genres as $album_genre) {
                        if ($album_genre->getIdGenre() == $genre) {
                            return true;
                        }
                    }
                    return false;
                });
            }
            if (isset($_POST['artist']) && $_POST['artist'] != '') {
                $filters['artist'] = $_POST['artist'];
                $artist = intval($_POST['artist']);
                $albums = array_filter($albums, function($album) use ($artist) {
                    return $album->getIdArtiste() == $artist;
                });
            }
            if (isset($_POST['year']) && $_POST['year'] != '') {
                $filters['year'] = $_POST['year'];
                $year = intval($_POST['year']);
                $albums = array_filter($albums, function($album) use ($year) {
                    return $album->getAnneeAlbum() == $year;
                });
            }
            global $main;
            global $css;
            $super_albums = [];
            foreach($albums as $album) {
                $super_albums[] = [
                    'Album' => $album,
                    'Artiste' => $this->artistFactory->getArtistById($album->getIdArtiste()),
                    'Image' => $this->albumFactory->getImageById($album->getIdImage()),
                ];
            }
            $genres = $this->albumFactory->getAllGenres();
            $artists = $this->artistFactory->getAllArtists();
            $years = $this->albumFactory->getAllYears();
            $main = require_once __DIR__ . '/../Views/album/index.php';
            $css = 'albums';
            require_once __DIR__ . '/../../public/index.php';
        }
    }

    public function detail(int $id) {
        $album = $this->albumFactory->getAlbumById($id)[0];
        $super_album = [];
        $super_album[] = [
            'Album' => $album,
            'Artiste' => $this->artistFactory->getArtistById($album->getIdArtiste()),
            'Image' => $this->albumFactory->getImageById($album->getIdImage()),
            'Genres' => $this->albumFactory->getGenresByAlbum($album->getIdAlbum()),
            'Musiques' => $this->albumFactory->getMusiquesByAlbum($album->getIdAlbum()),
            'Note' => $this->albumFactory->getNoteMoyenneByAlbum($album->getIdAlbum()),
        ]; 
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/album/detail.php';
        $css = '../../css/album';
        require_once __DIR__ .' /../../public/index.php';
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        }
        require_once 'app/Views/album/search.php';
    }

    public function update(int $id) {
        return null;
    }

    public function delete(int $id) {
        return null;
    }

    public function create() {
        return null;
    }
}