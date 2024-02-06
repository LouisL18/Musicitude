<?php
namespace app\Factories;

use app\Models\Artist;
use app\Models\Image;
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

    public function getUserIdByArtistId($id) {
        $stmt = $this->pdo->prepare('SELECT idUtilisateur FROM A_ROLE WHERE idArtiste = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getImageByArtistId($id) {
        $userId = $this->getUserIdByArtistId($id)[0];
        $stmt = $this->pdo->prepare('SELECT idImage FROM UTILISATEUR WHERE idUtilisateur = :id');
        $stmt->execute(['id' => $userId]);
        $idImage = $stmt->fetchColumn();
        $stmt = $this->pdo->prepare('SELECT * FROM IMAGE_BD WHERE idImage = :id');
        $stmt->execute(['id' => $idImage]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Image::class, [$idImage, 'nomImage', 'urlImage']);
    }
}
?>
