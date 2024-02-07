<?php 
namespace app\Controllers;

use app\Factories\AlbumFactory;
use app\Factories\ArtistFactory;
use app\Factories\UserFactory;
use app\Factories\PlaylistFactory;
class PlaylistController {
    protected $playlistFactory;
    protected $userFactory;
    protected $musiqueFactory;

    public function __construct(PlaylistFactory $playlistFactory, UserFactory $userFactory, MusiqueFactory $musiqueFactory) {
        $this->playlistFactory = $playlistFactory;
        $this->userFactory = $userFactory;
        $this->musiqueFactory = $musiqueFactory;
    }

    public function index() {
        $playlists = $this->playlistFactory->getAllPlaylists();
        $super_playlists = [];
        foreach ($playlists as $playlist) {
            $super_playlists[] = [
                'Playlist' => $playlist,
                'Musiques' => $this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist()),
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
        $super_playlist = [
            'Playlist' => $playlist,
            'Musiques' => $this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist()),
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
}
?>