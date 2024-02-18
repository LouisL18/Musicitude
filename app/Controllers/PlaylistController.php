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
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $playlists = $this->playlistFactory->getPlaylistsByUser($_SESSION['user_id']);
        $super_playlists = [];
        foreach ($playlists as $playlist) {
            $super_playlists[] = [
                'Playlist' => $playlist,
                'NbMusiques' => count($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())),
                'Images' => $this->albumFactory->getImagesByMusiques($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())),
            ];
        }
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/playlist/index.php';
        $css = 'playlists';
        require_once __DIR__ . '/../../public/index.php';
    }

    public function detail(int $id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        if ($_SESSION['user_id'] == $this->playlistFactory->getUserIdByPlaylist($id)) {
            $playlist = $this->playlistFactory->getPlaylistById($id)[0];
            $supers_musiques = [];
            foreach ($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist()) as $musique) {
                $supers_musiques[] = [
                    'Musique' => $musique,
                    'Album' => $this->albumFactory->getAlbumByMusique($musique->getIdMusique())[0],
                    'Image' => $this->albumFactory->getImageById($musique->getIdImage()),
                ];
            }
            $super_playlist = [
                'Playlist' => $playlist,
                'Musiques' => $supers_musiques,
                'Images' => $this->albumFactory->getImagesByMusiques($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())),
            ];
            global $main;
            global $css;
            $main = require_once __DIR__ . '/../Views/playlist/detail.php';
            $css = '../../css/playlist';
            require_once __DIR__ . '/../../public/index.php';
        }
        else {
            die('Vous n\'êtes pas l\'auteur de cette playlist');
        }
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            global $main;
            global $css;
            $main = require_once __DIR__ . '/../Views/playlist/create.php';
            $css = '../../css/playlist';
            require_once __DIR__ . '/../../public/index.php';
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->playlistFactory->create($_POST['nomPlaylist'], $_POST['descriptionPlaylist']);
            header('Location: /playlists');
        }
    }

    public function edit(int $id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        if ($_SESSION['user_id'] == $this->playlistFactory->getUserIdByPlaylist($id)) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $playlist = $this->playlistFactory->getPlaylistById($id)[0];
                global $main;
                global $css;
                $main = require_once __DIR__ . '/../Views/playlist/edit.php';
                $css = '../../../css/playlist';
                require_once __DIR__ . '/../../public/index.php';
            }
            elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->playlistFactory->update($id, $_POST['nomPlaylist'], $_POST['descriptionPlaylist']);
                header('Location: /playlist/' . $id);
            }
        }
        else {
            die('Vous n\'êtes pas l\'auteur de cette playlist');
        }
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

    public function remove(int $idPlaylist, int $idMusique) {
        $this->playlistFactory->removeMusiqueFromPlaylist($idPlaylist, $idMusique);
        http_response_code(200);
    }

    public function delete(int $id) {
        $this->playlistFactory->delete($id);
        http_response_code(200);
    }
}
?>