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

    public function getAlbumsByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE nomAlbum LIKE :name');
        $stmt->execute(['name' => '%'.$name.'%']);
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

    public function updateAlbum(int $id, string $nom, string $description, int $annee, array|null $genres, string|null $image) {
        $stmt = $this->pdo->prepare('UPDATE ALBUM SET nomAlbum = :nom, descriptionAlbum = :description, anneeAlbum = :annee WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id,
            'nom' => $nom,
            'description' => $description,
            'annee' => $annee
        ]);
        $stmt = $this->pdo->prepare('DELETE FROM EST_GENRE WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        foreach ($genres as $genre) {
            $stmt = $this->pdo->prepare('INSERT INTO EST_GENRE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)');
            $stmt->execute([
                'idAlbum' => $id,
                'idGenre' => intval($genre)
            ]);
        }
        if ($image != null) {
            $stmt = $this->pdo->prepare('UPDATE IMAGE_BD SET dataImage = :data WHERE idImage = (SELECT idImage FROM ALBUM WHERE idAlbum = :id)');
            $stmt->execute([
                'id'=> $id,
                'data' => $image
            ]);
        }
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
        $musiques = $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Musique::class, [intval('idMusique'), 'nomMusique', 'descriptionMusique', 'idImage']);
        $musiques_images = [];
        foreach ($musiques as $musique) {
            $musiques_images[] = [
                'Musique' => $musique,
                'Image' => $this->getImageById($musique->getIdImage())
            ];
        }
        return $musiques_images;

    }

    public function getNoteMoyenneByAlbum($id) {
        $stmt = $this->pdo->prepare('SELECT AVG(note) FROM NOTE WHERE idAlbum = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAllGenres() {
        $stmt = $this->pdo->query('SELECT * FROM GENRE');
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Genre::class, [intval('idGenre'), 'nomGenre', 'descriptionGenre']);
    }

    public function getAllYears() {
        $stmt = $this->pdo->query('SELECT DISTINCT anneeAlbum FROM ALBUM');
        return $stmt->fetchAll();
    }
}
?>