<?php
namespace app\Factories;

use app\Models\Artist;
use app\Models\Image;
use app\Factories\AlbumFactory;
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

    public function getArtisteByAlbum($id_album) {
        $stmt = $this->pdo->prepare('SELECT * FROM ARTISTE WHERE idArtiste = (SELECT idArtiste FROM ALBUM WHERE idAlbum = :id_album)');
        $stmt->execute(['id_album' => $id_album]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Artist::class, [intval('idArtiste'), 'nomArtiste', 'descriptionArtiste']);
    }

    public function getNoteMoyenneByArtist($id) {
        $albumFactory = new AlbumFactory($this->pdo);
        $albums = $albumFactory->getAlbumByArtist($id);
        $note = 0;
        $count = 0;
        foreach ($albums as $album) {
            $noteArray = $albumFactory->getNoteMoyenneByAlbum($album->getIdAlbum());
            if (is_array($noteArray) && count($noteArray) > 0) {
                $note += $noteArray[0];
                $count++;
            }
        }
        if ($count == 0) {
            return 0;
        }
        return $note / $count;
    }

    public function getNbNoteByArtist($id) {
        $albumFactory = new AlbumFactory($this->pdo);
        $albums = $albumFactory->getAlbumByArtist($id);
        $count = 0;
        foreach ($albums as $album) {
            $count += $albumFactory->getNbNoteByAlbum($album->getIdAlbum())[0];
        }
        return $count;
    }
}
?>
