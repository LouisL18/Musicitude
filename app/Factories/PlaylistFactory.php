<?php
namespace app\Factories;

use app\Models\Playlist;
use app\Models\Musique;
use PDO;

class PlaylistFactory {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllPlaylists() {
        $stmt = $this->pdo->query('SELECT * FROM PLAYLIST');
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Playlist::class, [intval('idPlaylist'), 'nomPlaylist', 'descriptionPlaylist']);
    }

    public function getPlaylistById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM PLAYLIST WHERE idPlaylist = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Playlist::class, [intval('idPlaylist'), 'nomPlaylist', 'descriptionPlaylist']);
    }

    public function getPlaylistByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM PLAYLIST WHERE nomPlaylist = :name');
        $stmt->execute(['nomPlaylist' => $name]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Playlist::class, [intval('idPlaylist'), 'nomPlaylist', 'descriptionPlaylist']);
    }

    public function getMusiquesByPlaylist($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM MUSIQUE WHERE idPlaylist = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Musique::class, [intval('idMusique'), 'nomMusique', 'descriptionMusique', 'idImage']);
    }
}
?>