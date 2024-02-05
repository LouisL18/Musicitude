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
        $albums = $this->albumFactory->getAllAlbums();
        $super_albums = [];
        foreach($albums as $album) {
            $super_albums[] = [
                'Album' => $album,
                'Artiste' => $this->artistFactory->getArtistById($album->getIdArtiste()),
                'Image' => $this->albumFactory->getImageById($album->getIdImage()),
            ];
        }
        //genres ? + artistes ? + ... ?
        require_once 'app/Views/album/index.php';
    }

    public function detail(int $id) {
        $album = $this->albumFactory->getAlbumById($id);
        //genres ? + artistes ? + ... ?
        require_once 'app/Views/album/detail.php';
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