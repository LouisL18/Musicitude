<?php
namespace app\Controllers;

use app\Factories\ArtistFactory;
use app\Factories\AlbumFactory;
use app\Factories\UserFactory;
use app\Factories\PlaylistFactory;

class HomeController {
    protected $artistFactory;
    protected $albumFactory;
    protected $userFactory;
    protected $playlistFactory;

    public function __construct(ArtistFactory $artistFactory, AlbumFactory $albumFactory, UserFactory $userFactory, PlaylistFactory $playlistFactory) {
        $this->artistFactory = $artistFactory;
        $this->albumFactory = $albumFactory;
        $this->userFactory = $userFactory;
        $this->playlistFactory = $playlistFactory;
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        //Partie pour les playlists
        $playlists = $this->playlistFactory->getPlaylistsByUser($_SESSION['user_id']);
        $super_playlists = [];
        foreach ($playlists as $playlist) {
            $super_playlists[] = [
                'Playlist' => $playlist,
                'NbMusiques' => count($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())),
                'Images' => $this->albumFactory->getImagesByMusiques($this->playlistFactory->getMusiquesByPlaylist($playlist->getIdPlaylist())),
            ];
        }
        usort($super_playlists, function($playlist_1, $playlist_2) {
            return $playlist_2['NbMusiques'] - $playlist_1['NbMusiques'];
        });
        $super_playlists = array_slice($super_playlists, 0, 5);
        //Partie pour les albums
        $albums = $this->albumFactory->getAllAlbums();
        foreach($albums as $album) {
            $super_albums[] = [
                'Album' => $album,
                'Artiste' => $this->artistFactory->getArtistById($album->getIdArtiste()),
                'Image' => $this->albumFactory->getImageById($album->getIdImage()),
                'Note' => $this->albumFactory->getNoteMoyenneByAlbum($album->getIdAlbum())
            ];
        }
        usort($super_albums, function($album_1, $album_2) {
            return $album_2['Note'][0] - $album_1['Note'][0];
        });
        $super_albums = array_slice($super_albums, 0, 5);
        //Partie pour les favoris
        $favoris = $this->userFactory->getFavoris($_SESSION['user_id']);
        $super_favoris = [];
        foreach ($favoris as $favori) {
            $super_favoris[] = [
                'Album' => $favori[0],
                'Artiste' => $this->artistFactory->getArtistById($favori[0]->getIdArtiste()),
                'Image' => $this->albumFactory->getImageById($favori[0]->getIdImage()),
                'Note' => $this->albumFactory->getNoteMoyenneByAlbum($favori[0]->getIdAlbum())
            ];
        }
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/home/index.php';
        $css = 'home';
        require_once __DIR__ . '/../../public/index.php';
    }
}
?>