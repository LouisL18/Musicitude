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

    public function getUserIdByPlaylist(int $id) {
        $stmt = $this->pdo->prepare('SELECT idUtilisateur FROM A_PLAYLIST WHERE idPlaylist = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function removeMusiqueFromPlaylist(int $idPlaylist, int $idMusique) {
        $stmt = $this->pdo->prepare('DELETE FROM EST_DANS WHERE idPlaylist = :idPlaylist AND idMusique = :idMusique');
        $stmt->execute(['idPlaylist' => $idPlaylist, 'idMusique' => $idMusique]);
    }

    public function create(string $nom, string $description) {
        $stmt = $this->pdo->query('SELECT MAX(idPlaylist) FROM PLAYLIST');
        $id = $stmt->fetch(PDO::FETCH_COLUMN) + 1;
        $stmt = $this->pdo->prepare('INSERT INTO PLAYLIST (idPlaylist, nomPlaylist, descriptionPlaylist) VALUES (:id, :nom, :description)');
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'description' => $description
        ]);
        $stmt = $this->pdo->query('SELECT MAX(idPlaylist) FROM PLAYLIST');
        $stmt = $this->pdo->prepare('INSERT INTO A_PLAYLIST (idUtilisateur, idPlaylist) VALUES (:idUtilisateur, :idPlaylist)');
        $stmt->execute([
            'idUtilisateur' => $_SESSION['user_id'],
            'idPlaylist' => $id
        ]);
    }

    public function update(int $id, string $nom, string $description) {
        $stmt = $this->pdo->prepare('UPDATE PLAYLIST SET nomPlaylist = :nom, descriptionPlaylist = :description WHERE idPlaylist = :id');
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'description' => $description
        ]);
    }
}
?> 