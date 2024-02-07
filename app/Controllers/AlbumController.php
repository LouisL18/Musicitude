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

    public function index(array|null $albums = null) {
        //$albums = $this->albumFactory->getAllAlbums();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($albums != null) {
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
                $main = require_once __DIR__ . '/../Views/album/index.php';
                $css = 'albums';
                require_once __DIR__ . '/../../public/index.php';
            }
            else {
                return $this->index($this->albumFactory->getAllAlbums());
            }
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albums = $this->albumFactory->getAllAlbums();
            if (isset($_POST['search']) && $_POST['search'] != '') {
                $albums = array_filter($albums, function($album) {
                    return strpos($album->getNomAlbum(), $_POST['search']) !== false;
                });
            }
            elseif (isset($_POST['genre']) && $_POST['genre'] != '') {
                $albums = array_filter($albums, function($album) {
                    $album_genres = $this->albumFactory->getGenresByAlbum($album->getIdAlbum());
                    foreach ($album_genres as $genre) {
                        if ($genre->getIdGenre() == intval($_POST['genre'])) {
                            return true;
                        }
                    }
                });
            }
            elseif (isset($_POST['artist']) && $_POST['artist'] != '') {
                $albums = array_filter($albums, function($album) {
                    return $album->getIdArtiste() == intval($_POST['artist']);
                });
            }
            elseif (isset($_POST['year']) && $_POST['year'] != '') {
                $albums = array_filter($albums, function($album) {
                    return $album->getAnneeAlbum() == intval($_POST['year']);
                });
            }
            return $this->index($albums);
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