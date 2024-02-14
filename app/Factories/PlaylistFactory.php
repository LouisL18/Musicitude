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
        $stmt = $this->pdo->prepare('SELECT * FROM MUSIQUE WHERE idMusique IN (SELECT idMusique FROM EST_DANS WHERE idPlaylist = :id)');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Musique::class, [intval('idMusique'), 'nomMusique', 'descriptionMusique', 'idImage']);
    }

    public function getPlaylistsByUser(int $id) {
        $stmt = $this->pdo->prepare('SELECT * FROM PLAYLIST WHERE idPlaylist IN (SELECT idPlaylist FROM A_PLAYLIST WHERE idUtilisateur = :id)');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Playlist::class, [intval('idPlaylist'), 'nomPlaylist', 'idUtilisateur']);
    }

    public function addMusiqueToPlaylist(int $idPlaylist, int $idMusique) {
        $stmt = $this->pdo->prepare('INSERT INTO EST_DANS (idPlaylist, idMusique) VALUES (:idPlaylist, :idMusique)');
        $stmt->execute(['idPlaylist' => $idPlaylist, 'idMusique' => $idMusique]);
    }
}
?> 