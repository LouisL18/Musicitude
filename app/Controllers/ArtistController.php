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
        $super_artists = [];
        foreach ($artists as $artist) {
            $super_artists[] = [
                'Artist' => $artist,
                'Image' => $this->artistFactory->getImageByArtistId($artist->getIdArtiste()),
            ];
        }
        global $main;
        $main = require_once __DIR__.'/../Views/artist/index.php';
        require_once __DIR__.'/../../public/index.php';
    }

    public function detail(int $id) {
        $artist = $this->artistFactory->getArtistById($id)[0];
        $super_artist = [
            'Artist' => $artist,
            'Image' => $this->artistFactory->getImageByArtistId($artist->getIdArtiste()),
            'Albums' => $this->albumFactory->getAlbumByArtist($artist->getIdArtiste()),
        ];
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