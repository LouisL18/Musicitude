<?php 
namespace app\Controllers;

use app\Factories\AlbumFactory;
use app\Factories\UserFactory;
use app\Factories\PlaylistFactory;
use app\Factories\ArtistFactory;

class PlaylistController {
    protected $playlistFactory;
    protected $userFactory;
    protected $albumFactory;
    protected $artistFactory;

    public function __construct(PlaylistFactory $playlistFactory, UserFactory $userFactory, AlbumFactory $albumFactory, ArtistFactory $artistFactory) {
        $this->playlistFactory = $playlistFactory;
        $this->userFactory = $userFactory;
        $this->albumFactory = $albumFactory;
        $this->artistFactory = $artistFactory;
    }

    public function index() {
        $playlists = $this->playlistFactory->getAllPlaylists();
        $super_playlists = [];
        foreach ($playlists as $playlist) {
            $musique1 = $this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())[0];
            $super_playlists[] = [
                'Playlist' => $playlist,
                'NbMusiques' => count($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())),
                'Image' => $this->albumFactory->getImageById($musique1->getIdImage()),
            ];
        }
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/playlist/index.php';
        $css = 'playlists';
        require_once __DIR__ . '/../../public/index.php';
    }

    public function detail(int $id) {
        $playlist = $this->playlistFactory->getPlaylistById($id)[0];
        $supers_musiques = [];
        foreach ($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist()) as $musique) {
            $supers_musiques[] = [
                'Musique' => $musique,
                'Album' => $this->albumFactory->getAlbumByMusique($musique->getIdMusique())[0],
                'Artiste' => $this->artistFactory->getArtisteByAlbum($this->albumFactory->getAlbumById($musique->getIdAlbum())[0]->getIdAlbum())[0],
                'Image' => $this->albumFactory->getImageById($musique->getIdImage()),
            ];
        }
        $super_playlist = [
            'Playlist' => $playlist,
            'Musiques' => $supers_musiques,
        ];
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/playlist/detail.php';
        $css = '../../css/playlist';
        require_once __DIR__ . '/../../public/index.php';
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        }
        require_once 'app/Views/playlist/search.php';
    }

    public function add(int $idPlaylist, int $idMusique) {
        $this->playlistFactory->addMusiqueToPlaylist($idPlaylist, $idMusique);
        http_response_code(200);
    }
}
?>