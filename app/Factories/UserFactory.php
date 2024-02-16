<?php
namespace app\Factories;

use app\Models\User;
use app\Models\Image;
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

    public function updateUser(User $user) {
        $stmt = $this->pdo->prepare('UPDATE UTILISATEUR SET nomUtilisateur = :nomUtilisateur, prenomUtilisateur = :prenomUtilisateur, emailUtilisateur = :emailUtilisateur, motDePasseUtilisateur = :motDePasseUtilisateur, idImage = :idImage WHERE idUtilisateur = :idUtilisateur');
        $stmt->execute([
            'nomUtilisateur' => $user->getNomUtilisateur(),
            'prenomUtilisateur'=> $user->getPrenomUtilisateur(),
            'emailUtilisateur' => $user->getEmailUtilisateur(),
            'motDePasseUtilisateur' => $user->getMotDePasseUtilisateur(),
            'idImage' => $user->getIdImage(),
            'idUtilisateur' => $user->getIdUtilisateur()
            ]);
        return true;
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare('DELETE FROM UTILISATEUR WHERE idUtilisateur = :id');
        $stmt->execute(['id' => $id]);
        return true;
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