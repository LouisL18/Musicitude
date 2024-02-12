<?php
namespace app\Factories;

use app\Models\Album;
use app\Models\Image;
use app\Models\Genre;
use app\Models\Musique;
use PDO;

class AlbumFactory {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllAlbums() {
        $stmt = $this->pdo->query('SELECT * FROM ALBUM');
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }

    public function getAlbumById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE idAlbum = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }

    public function getAlbumByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE nomAlbum = :nom');
        $stmt->execute(['nom' => $name]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }

    public function getAlbumByArtist($id_artist) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE idArtiste = :id_artist');
        $stmt->execute(['id_artist' => $id_artist]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }

    public function createAlbum(Album $album) {
        $stmt = $this->pdo->prepare('INSERT INTO ALBUM (nomAlbum, descriptionAlbum, anneeAlbum, idArtiste, idImage) VALUES (:nomAlbum, :descriptionAlbum, :anneeAlbum, :idArtiste, :idImage)');
        $stmt->execute([
            'nomAlbum' => $album->getNomAlbum(),
            'descriptionAlbum'=> $album->getDescriptionAlbum(),
            'anneeAlbum' => $album->getAnneeAlbum(),
            'idArtiste' => $album->getIdArtiste(),
            'idImage' => $album->getIdImage()
            ]);
        return true;
    }

    public function updateAlbum(Album $album) {
        $stmt = $this->pdo->prepare('UPDATE ALBUM SET nomAlbum = :nomAlbum, descriptionAlbum = :descriptionAlbum, anneeAlbum = :anneeAlbum, idArtiste = :idArtiste, idImage = :idImage WHERE idAlbum = :idAlbum');
        $stmt->execute([
            'nomAlbum' => $album->getNomAlbum(),
            'descriptionAlbum'=> $album->getDescriptionAlbum(),
            'anneeAlbum' => $album->getAnneeAlbum(),
            'idArtiste' => $album->getIdArtiste(),
            'idImage' => $album->getIdImage(),
            'idAlbum' => $album->getIdAlbum()
            ]);
        return true;
    }

    public function deleteAlbum($id) {
        $stmt = $this->pdo->prepare('DELETE FROM ALBUM WHERE idAlbum = :id');
        $stmt->execute(['id' => $id]);
        return true;
    }

    public function getImageById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM IMAGE_BD WHERE idImage = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Image::class, [intval('idImage'), 'nomImage', 'dataImage']);
    }

    public function getGenresByAlbum($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM GENRE NATURAL JOIN EST_GENRE WHERE idAlbum = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Genre::class, [intval('idGenre'), 'nomGenre', 'descriptionGenre']);
    }

    public function getMusiquesByAlbum($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM MUSIQUE NATURAL JOIN EST_CONSTITUE where idAlbum = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Musique::class, [intval('idMusique'), 'nomMusique', 'descriptionMusique', 'idImage']);
    }

    public function getNoteMoyenneByAlbum($id) {
        $stmt = $this->pdo->prepare('SELECT AVG(note) FROM NOTE WHERE idAlbum = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAlbumByMusique($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE idAlbum = (SELECT idAlbum FROM EST_CONSTITUE WHERE idMusique = :id)');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }
}
?>