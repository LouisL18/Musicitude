<?php
namespace app\Factories;

use app\Models\Artist;
use PDO;

class ArtistFactory {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllArtists() {
        $stmt = $this->pdo->query('SELECT * FROM ARTISTE');
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Artist::class, [intval('idArtiste'), 'nomArtiste', 'descriptionArtiste']);
    }

    public function getArtistById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM ARTISTE WHERE idArtiste = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Artist::class, [intval('idArtiste'), 'nomArtiste', 'descriptionArtiste']);
    }

    public function getArtistByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM ARTISTE WHERE nomArtiste = :name');
        $stmt->execute(['nomArtiste' => $name]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Artist::class, [intval('idArtiste'), 'nomArtiste', 'descriptionArtiste']);
    }

    public function createArtist(string $nom , string $description) {
        $stmt = $this->pdo->query('SELECT MAX(idArtiste) FROM ARTISTE');
        $idArtiste = $stmt->fetchColumn() + 1;
        $stmt = $this->pdo->prepare('INSERT INTO ARTISTE (idArtiste, nomArtiste, descriptionArtiste) VALUES (:idArtiste, :nomArtiste, :descriptionArtiste)');
        $stmt->execute([
            'idArtiste' => $idArtiste,
            'nomArtiste' => $nom,
            'descriptionArtiste'=> $description
            ]);
        return $idArtiste;
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
