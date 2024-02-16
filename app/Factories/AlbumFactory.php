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

    public function createAlbum(string $nom, string $description, int $annee, array|null $genres, array|null $noms_musiques, array|null $descriptions_musiques, array|null $images_musiques, string|null $image, array|null $data_musiques) {
        $stmt = $this->pdo->query('SELECT MAX(idImage) FROM IMAGE_BD');
        $id_image_album = $stmt->fetch(PDO::FETCH_COLUMN) + 1;
        $stmt = $this->pdo->prepare('INSERT INTO IMAGE_BD (idImage, nomImage, dataImage) VALUES (:idImage, :nomImage, :dataImage)');
        $stmt->execute([
            'idImage' => $id_image_album,
            'nomImage' => $id_image_album . '_image',
            'dataImage' => $image
        ]);
        $stmt = $this->pdo->query('SELECT MAX(idAlbum) FROM ALBUM');
        $id_album = $stmt->fetch(PDO::FETCH_COLUMN) + 1;
        $stmt = $this->pdo->prepare('INSERT INTO ALBUM (idAlbum, nomAlbum, descriptionAlbum, anneeAlbum, idArtiste, idImage) VALUES (:idAlbum, :nomAlbum, :descriptionAlbum, :anneeAlbum, :idArtiste, :idImage)');
        $stmt->execute([
            'idAlbum' => $id_album,
            'nomAlbum' => $nom,
            'descriptionAlbum' => $description,
            'anneeAlbum' => $annee,
            'idArtiste' => $_SESSION['artist_id'],
            'idImage' => $id_image_album
        ]);
        foreach ($genres as $genre) {
            $stmt = $this->pdo->prepare('INSERT INTO EST_GENRE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)');
            $stmt->execute([
                'idAlbum' => $id_album,
                'idGenre' => intval($genre)
            ]);
        }
        //insert musiques
        if ($noms_musiques != null) {
            for ($i = 0; $i < count($noms_musiques); $i++) {
                    $stmt = $this->pdo->query('SELECT MAX(idImage) FROM IMAGE_BD');
                    $id_image_musique = $stmt->fetch(PDO::FETCH_COLUMN) + 1;
                    $stmt = $this->pdo->prepare('INSERT INTO IMAGE_BD (idImage, nomImage, dataImage) VALUES (:idImage, :nomImage, :dataImage)');
                    
                    $data_image = $images_musiques[$i] != "" ? base64_encode(file_get_contents($images_musiques[$i])) : base64_encode(file_get_contents(__DIR__ . '/../../public/images/default.jpg'));
                    $stmt->execute([
                        'idImage' => $id_image_musique,
                        'nomImage' => $id_image_musique . '_image',
                        'dataImage' => $data_image
                    ]);
                $stmt = $this->pdo->query('SELECT MAX(idMusique) FROM MUSIQUE');
                $id_musique = $stmt->fetch(PDO::FETCH_COLUMN) + 1;
                $stmt = $this->pdo->prepare('INSERT INTO MUSIQUE (idMusique, nomMusique, descriptionMusique, dataMusique, idImage) VALUES (:idMusique, :nomMusique, :descriptionMusique, :dataMusique, :idImage)');
                $data_musique = $data_musiques[$i] != "" ? base64_encode(file_get_contents($data_musiques[$i])) : null;
                $stmt->execute([
                    'idMusique' => $id_musique,
                    'nomMusique' => $noms_musiques[$i],
                    'descriptionMusique' => $descriptions_musiques[$i],
                    'dataMusique' => $data_musique,
                    'idImage' => $id_image_musique
                ]);
                $stmt = $this->pdo->prepare('INSERT INTO EST_CONSTITUE (idAlbum, idMusique) VALUES (:idAlbum, :idMusique)');
                $stmt->execute([
                    'idAlbum' => $id_album,
                    'idMusique' => $id_musique
                ]);
            }
        }
    }

    public function updateAlbum(int $id, string $nom, string $description, int $annee, array|null $genres, string|null $image, array|null $musiques_names, array|null $musiques_descriptions, array|null $musiques_images, array|null $musiques_data, array|null $musiques_ids) {
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
        if ($musiques_names != null) {
            for ($i = 0; $i < count($musiques_names); $i++) {
                $idMusique = $musiques_ids[$i]; // Assuming you have an array of idMusique values

                if ($musiques_images[$i] != null && $musiques_images[$i] != "") {
                    $stmt = $this->pdo->prepare('UPDATE IMAGE_BD SET dataImage = :data WHERE idImage = (SELECT idImage FROM MUSIQUE WHERE idMusique = :idMusique)');
                    $stmt->execute([
                        'idMusique' => $idMusique,
                        'data' => base64_encode(file_get_contents($musiques_images[$i]))
                    ]);
                }
                if ($musiques_data[$i] != null && $musiques_data[$i] != "") {
                    $stmt = $this->pdo->prepare('UPDATE MUSIQUE SET dataMusique = :data WHERE idMusique = :idMusique');
                    $stmt->execute([
                        'idMusique' => $idMusique,
                        'data' => base64_encode(file_get_contents($musiques_data[$i]))
                    ]);
                }
                $stmt = $this->pdo->prepare('UPDATE MUSIQUE SET nomMusique = :nom, descriptionMusique = :description WHERE idMusique = :idMusique');
                $stmt->execute([
                    'idMusique' => $idMusique,
                    'nom' => $musiques_names[$i],
                    'description' => $musiques_descriptions[$i]
                ]);
            }
        }
    }

    public function deleteAlbum($id) {
        //recupérer les musiques de l'album
        $stmt = $this->pdo->prepare('SELECT idMusique FROM EST_CONSTITUE WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        $musiques = $stmt->fetchAll(PDO::FETCH_COLUMN);
        //delete EST_CONSTITUE
        $stmt = $this->pdo->prepare('DELETE FROM EST_CONSTITUE WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        //delete NOTE
        $stmt = $this->pdo->prepare('DELETE FROM NOTE WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        //delete FAVORIS
        $stmt = $this->pdo->prepare('DELETE FROM FAVORIS WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        //delete EST_GENRE
        $stmt = $this->pdo->prepare('DELETE FROM EST_GENRE WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        // Réccupérer l'id de l'image de l'album
        $stmt = $this->pdo->prepare('SELECT idImage FROM ALBUM WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        $id_image_album = $stmt->fetch(PDO::FETCH_COLUMN);
        //delete ALBUM
        $stmt = $this->pdo->prepare('DELETE FROM ALBUM WHERE idAlbum = :id');
        $stmt->execute([
            'id'=> $id
        ]);
        //delete IMAGE_BD
        $stmt = $this->pdo->prepare('DELETE FROM IMAGE_BD WHERE idImage = :id');
        $stmt->execute([
            'id'=> $id_image_album
        ]);
        //delete EST_DANS
        foreach ($musiques as $musique) {
            $stmt = $this->pdo->prepare('DELETE FROM EST_DANS WHERE idMusique = :id');
            $stmt->execute([
                'id'=> $musique
            ]);
        }
        //recupérer les images des musiques
        $id_image_musiques = [];
        foreach ($musiques as $musique) {
            $stmt = $this->pdo->prepare('SELECT idImage FROM MUSIQUE WHERE idMusique = :id');
            $stmt->execute([
                'id'=> $musique
            ]);
            $id_image_musiques[] = $stmt->fetch(PDO::FETCH_COLUMN);
        }
        //delete MUSIQUE
        foreach ($musiques as $musique) {
            $stmt = $this->pdo->prepare('DELETE FROM MUSIQUE WHERE idMusique = :id');
            $stmt->execute([
                'id'=> $musique
            ]);
        }
        //delete IMAGE_BD
        foreach ($id_image_musiques as $id_image_musique) {
            $stmt = $this->pdo->prepare('DELETE FROM IMAGE_BD WHERE idImage = :id');
            $stmt->execute([
                'id'=> $id_image_musique
            ]);
        }
        http_response_code(200);
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
        $musiques = $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Musique::class, [intval('idMusique'), 'nomMusique', 'descriptionMusique', 'dataMusique', 'idImage']);
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

    public function getAlbumByMusique($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE idAlbum = (SELECT idAlbum FROM EST_CONSTITUE WHERE idMusique = :id)');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }

    public function getAllGenres() {
        $stmt = $this->pdo->query('SELECT * FROM GENRE');
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Genre::class, [intval('idGenre'), 'nomGenre', 'descriptionGenre']);
    }

    public function getAllYears() {
        $stmt = $this->pdo->query('SELECT DISTINCT anneeAlbum FROM ALBUM');
        return $stmt->fetchAll();
    }

    public function getImagesByMusiques($musiques) {
        $images = [];
        foreach ($musiques as $musique) {
            $stmt = $this->pdo->prepare('SELECT * FROM IMAGE_BD WHERE idImage = (SELECT idImage FROM MUSIQUE WHERE idMusique = :id)');
            $stmt->execute(['id' => $musique->getIdMusique()]);
            $images[] = $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Image::class, [intval('idImage'), 'nomImage', 'dataImage']);
        }
        return $images;
    }

    public function getAlbumByPlaylist($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM ALBUM WHERE idAlbum = (SELECT idAlbum FROM EST_CONSTITUE WHERE idMusique = (SELECT idMusique FROM EST_DANS WHERE idPlaylist = :id))');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
    }

    public function rateAlbum($id, $note) {
        $stmt = $this->pdo->prepare('INSERT OR REPLACE INTO NOTE (idUtilisateur, idAlbum, note) VALUES (:idUser, :idAlbum, :note)');
        $stmt->execute([
            'idUser' => $_SESSION['user_id'],
            'idAlbum' => $id,
            'note' => $note
        ]);
    }

    public function deleteMusic($id) {
        $stmt = $this->pdo->prepare('DELETE FROM IMAGE_BD WHERE idImage = (SELECT idImage FROM MUSIQUE WHERE idMusique = :id)');
        $stmt->execute(['id' => $id]);
        $stmt = $this->pdo->prepare('DELETE FROM EST_DANS WHERE idMusique = :id');
        $stmt->execute(['id' => $id]);
        $stmt = $this->pdo->prepare('DELETE FROM EST_CONSTITUE WHERE idMusique = :id');
        $stmt->execute(['id' => $id]);
        $stmt = $this->pdo->prepare('DELETE FROM MUSIQUE WHERE idMusique = :id');
        $stmt->execute(['id' => $id]);
    }
}
?>