<?php
namespace app\Controllers;

use app\Factories\ArtistFactory;
use app\Factories\AlbumFactory;
use app\Factories\UserFactory;

class ArtistController {
    protected $artistFactory;
    protected $albumFactory;
    protected $userFactory;

    public function __construct(ArtistFactory $artistFactory, AlbumFactory $albumFactory, UserFactory $userFactory) {
        $this->artistFactory = $artistFactory;
        $this->albumFactory = $albumFactory;
        $this->userFactory = $userFactory;
    }

    public function index() {
        $artists = $this->artistFactory->getAllArtists();
        require_once 'app/Views/artist/index.php';
    }

    public function detail(int $id) {
        $artist = $this->artistFactory->getArtistById($id);
        //albums ? + genres ? + ... ?
        require_once 'app/Views/artist/detail.php';
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
?>