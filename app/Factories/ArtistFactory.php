<?php
namespace app\Factories;

use app\Models\Artist;
use PDO;

class AlbumFactory {
    protected $pdo;

    public function getAllArtists() {
        $stmt = $this->pdo->query('SELECT * FROM ARTISTE');
        return $stmt->fetchAll(PDO::FETCH_CLASS, Artist::class);
    }

    public function getArtistById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM ARTISTE WHERE idArtiste = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Artist::class);
    }

    public function getArtistByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM ARTISTE WHERE nomArtiste = :name');
        $stmt->execute(['nomArtiste' => $name]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Artist::class);
    }

    public function createArtist(Artist $artist) {
        $stmt = $this->pdo->prepare('INSERT INTO ARTISTE (nomArtiste, descriptionArtiste) VALUES (:nomArtiste, :descriptionArtiste)');
        $stmt->execute([
            'nomArtiste' => $artist->getNomArtiste(),
            'descriptionArtiste'=> $artist->getDescriptionArtiste()
            ]);
        return true;
    }

    public function updateArtist(Artist $artist) {
        $stmt = $this->pdo->prepare('UPDATE ARTISTE SET nomArtiste = :nomArtiste, descriptionArtiste = :descriptionArtiste WHERE idArtiste = :idArtiste');
        $stmt->execute([
            'nomArtiste' => $artist->getNomArtiste(),
            'descriptionArtiste'=> $artist->getDescriptionArtiste(),
            'idArtiste' => $artist->getIdArtiste()
            ]);
        return true;
    }

    public function deleteArtist($id) {
        $stmt = $this->pdo->prepare('DELETE FROM ARTISTE WHERE idArtiste = :id');
        $stmt->execute(['id' => $id]);
        return true;
    }
}
?>
