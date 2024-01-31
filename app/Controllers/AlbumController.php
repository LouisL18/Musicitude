<?php
namespace app\Controllers;

use app\Models\Album;
use app\Factories\AlbumFactory;

class AlbumController {
    protected $albumFactory;

    public function __construct(AlbumFactory $albumFactory) {
        $this->albumFactory = $albumFactory;
    }

    public function index() {
        $albums = $this->albumFactory->getAllAlbums();
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