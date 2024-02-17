<?php
namespace app\Factories;

use app\Models\User;
use app\Models\Image;
use app\Models\Album;
use PDO;

class UserFactory {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query('SELECT * FROM UTILISATEUR');
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [intval('idUtilisateur'), 'nomUtilisateur', 'prenomUtilisateur', 'emailUtilisateur', 'motDePasseUtilisateur', intval('idImage')]);
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM UTILISATEUR WHERE idUtilisateur = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [intval('idUtilisateur'), 'nomUtilisateur', 'prenomUtilisateur', 'emailUtilisateur', 'motDePasseUtilisateur', intval('idImage')]);
    }

    public function getUserByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM UTILISATEUR WHERE nomUtilisateur = :name');
        $stmt->execute(['nomUtilisateur' => $name]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [intval('idUtilisateur'), 'nomUtilisateur', 'prenomUtilisateur', 'emailUtilisateur', 'motDePasseUtilisateur', intval('idImage')]);
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM UTILISATEUR WHERE emailUtilisateur = :emailUtilisateur');
        $stmt->execute(['emailUtilisateur' => $email]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [intval('idUtilisateur'), 'nomUtilisateur', 'prenomUtilisateur', 'emailUtilisateur', 'motDePasseUtilisateur', intval('idImage')]);
    }

    public function createUser(string $nom, string $prenom, string $email, string $mdp, string $image) {
        if ($this->getUserByEmail($email) != []) {
            header('Location: /register');
            return null;
        }
        $stmt = $this->pdo->query('SELECT MAX(idImage) FROM IMAGE_BD');
        $idImage = $stmt->fetchColumn() + 1;
        $stmt = $this->pdo->prepare('INSERT INTO IMAGE_BD (idImage, nomImage, dataImage) VALUES (:idImage, :nomImage, :dataImage)');
        $stmt->execute([
            'idImage' => $idImage,
            'nomImage' => $idImage . '_image',
            'dataImage' => $image
            ]);
        $stmt = $this->pdo->query('SELECT MAX(idUtilisateur) FROM UTILISATEUR');
        $idUtilisateur = $stmt->fetchColumn() + 1;
        $stmt = $this->pdo->prepare('INSERT INTO UTILISATEUR (idUtilisateur, nomUtilisateur, prenomUtilisateur, emailUtilisateur, motDePasseUtilisateur, idImage) VALUES (:idUtilisateur, :nomUtilisateur, :prenomUtilisateur, :emailUtilisateur, :motDePasseUtilisateur, :idImage)');
        $stmt->execute([
            'idUtilisateur' => $idUtilisateur,
            'nomUtilisateur' => $nom,
            'prenomUtilisateur'=> $prenom,
            'emailUtilisateur' => $email,
            'motDePasseUtilisateur' => $mdp,
            'idImage' => $idImage
            ]);
        return $idUtilisateur;
    }

    public function addRole(int $idUtilisateur, int $idRole, int|null $idArtiste) {
        $stmt = $this->pdo->prepare('INSERT INTO A_ROLE (idUtilisateur, idRole, idArtiste) VALUES (:idUtilisateur, :idRole, :idArtiste)');
        $stmt->execute([
            'idUtilisateur' => $idUtilisateur,
            'idRole' => $idRole,
            'idArtiste' => $idArtiste
            ]);
        return true;
    }

    public function updateUser(string $nom, string $prenom, string $email, string $mdp, string|null $image) {
        if ($image != null) {
            $stmt = $this->pdo->prepare('UPDATE IMAGE_BD SET dataImage = :dataImage WHERE idImage = (SELECT idImage FROM UTILISATEUR WHERE idUtilisateur = :idUtilisateur)');
            $stmt->execute([
                'dataImage' => $image,
                'idUtilisateur' => $_SESSION['user_id']
                ]);
        }
        $stmt = $this->pdo->prepare('UPDATE UTILISATEUR SET nomUtilisateur = :nomUtilisateur, prenomUtilisateur = :prenomUtilisateur, emailUtilisateur = :emailUtilisateur, motDePasseUtilisateur = :motDePasseUtilisateur WHERE idUtilisateur = :idUtilisateur');
        $stmt->execute([
            'nomUtilisateur' => $nom,
            'prenomUtilisateur'=> $prenom,
            'emailUtilisateur' => $email,
            'motDePasseUtilisateur' => $mdp,
            'idUtilisateur' => $_SESSION['user_id']
            
            ]);
        return true;
    }

    public function deleteUser() {
        if (isset($_SESSION['artist_id'])) {
            $stmt = $this->pdo->prepare('SELECT idAlbum FROM ALBUM WHERE idArtiste = :id');
            $stmt->execute(['id' => $_SESSION['artist_id']]);
            $albums = $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Album::class, [intval('idAlbum'), 'nomAlbum', 'descriptionAlbum', intval('anneeAlbum'), intval('idArtiste'), intval('idImage')]);
            foreach ($albums as $album) {
                $id_album = $album->getIdAlbum();
                //recupérer les musiques de l'album
                $stmt = $this->pdo->prepare('SELECT idMusique FROM EST_CONSTITUE WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
                ]);
                $musiques = $stmt->fetchAll(PDO::FETCH_COLUMN);
                //delete EST_CONSTITUE
                $stmt = $this->pdo->prepare('DELETE FROM EST_CONSTITUE WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
                ]);
                //delete NOTE
                $stmt = $this->pdo->prepare('DELETE FROM NOTE WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
                ]);
                //delete FAVORIS
                $stmt = $this->pdo->prepare('DELETE FROM FAVORIS WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
                ]);
                //delete EST_GENRE
                $stmt = $this->pdo->prepare('DELETE FROM EST_GENRE WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
                ]);
                // Réccupérer l'id de l'image de l'album
                $stmt = $this->pdo->prepare('SELECT idImage FROM ALBUM WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
                ]);
                $id_image_album = $stmt->fetch(PDO::FETCH_COLUMN);
                //delete ALBUM
                $stmt = $this->pdo->prepare('DELETE FROM ALBUM WHERE idAlbum = :id');
                $stmt->execute([
                    'id'=> $id_album
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
            }
        }
        //delete A_ROLE
        $stmt = $this->pdo->prepare('DELETE FROM A_ROLE WHERE idUtilisateur = :id');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
        //delete PLAYLIST
        $stmt = $this->pdo->prepare('DELETE FROM PLAYLIST WHERE idPlaylist = (SELECT idPlaylist FROM A_PLAYLIST WHERE idUtilisateur = :id)');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
        //delete A_PLAYLIST
        $stmt = $this->pdo->prepare('DELETE FROM A_PLAYLIST WHERE idUtilisateur = :id');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
        //delete FAVORIS
        $stmt = $this->pdo->prepare('DELETE FROM FAVORIS WHERE idUtilisateur = :id');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
        //delete NOTE
        $stmt = $this->pdo->prepare('DELETE FROM NOTE WHERE idUtilisateur = :id');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
        //delete IMAGE_BD
        $stmt = $this->pdo->prepare('DELETE FROM IMAGE_BD WHERE idImage = (SELECT idImage FROM UTILISATEUR WHERE idUtilisateur = :id)');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
        //delete UTILISATEUR
        $stmt = $this->pdo->prepare('DELETE FROM UTILISATEUR WHERE idUtilisateur = :id');
        $stmt->execute([
            'id'=> $_SESSION['user_id']
        ]);
    }

    public function getArtistId(int $id) {
        $stmt = $this->pdo->prepare('SELECT idArtiste FROM A_ROLE WHERE idUtilisateur = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getRole(int $id) {
        $stmt = $this->pdo->prepare('SELECT idRole FROM A_ROLE WHERE idUtilisateur = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getImage(int $id) {
        $stmt = $this->pdo->prepare('SELECT * FROM IMAGE_BD WHERE idImage = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Image::class, [intval('idImage'), 'nomImage', 'dataImage']);
    }
}
?>