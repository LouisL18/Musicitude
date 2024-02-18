<?php
namespace app\Controllers;

use app\Factories\ArtistFactory;
use app\Factories\AlbumFactory;
use app\Factories\UserFactory;
use app\Models\Artist;

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
        global $css;
        $main = require_once __DIR__ . '/../Views/artist/index.php';
        $css = 'artists';
        require_once __DIR__ . '/../../public/index.php';
    }

    public function detail(int $id) {
        $artist = $this->artistFactory->getArtistById($id)[0];
        $super_albums = [];
        $albums = $this->albumFactory->getAlbumByArtist($artist->getIdArtiste());
        foreach ($albums as $album) {
            $super_albums[] = [
                'Album' => $album,
                'Image' => $this->albumFactory->getImageById($album->getIdImage()),
            ];
        }
        $super_artist = [
            'Artist' => $artist,
            'Image' => $this->artistFactory->getImageByArtistId($artist->getIdArtiste()),
            'Albums' => $super_albums,
            'Note' => $this->artistFactory->getNoteMoyenneByArtist($artist->getIdArtiste()),
            'NbNotes' => $this->artistFactory->getNbNoteByArtist($artist->getIdArtiste()),
        ];
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/artist/detail.php';
        $css = '../../css/artist';
        require_once __DIR__ . '/../../public/index.php';
    }
}
?>