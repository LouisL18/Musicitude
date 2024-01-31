<?php
namespace app\Factories;

use app\Models\User;
use PDO;

class UserFactory {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query('SELECT * FROM UTILISATEUR');
        return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM UTILISATEUR WHERE idUtilisateur = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(User::class);
    }

    public function getUserByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM UTILISATEUR WHERE nomUtilisateur = :name');
        $stmt->execute(['nomUtilisateur' => $name]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM UTILISATEUR WHERE emailUtilisateur = :email');
        $stmt->execute(['emailUtilisateur' => $email]);
        return $stmt->fetchObject(User::class);
    }

    public function createUser(User $user) {
        $stmt = $this->pdo->prepare('INSERT INTO UTILISATEUR (nomUtilisateur, prenomUtilisateur, emailUtilisateur, motDePasseUtilisateur, idImage) VALUES (:nomUtilisateur, :prenomUtilisateur, :emailUtilisateur, :motDePasseUtilisateur, :idImage)');
        $stmt->execute([
            'nomUtilisateur' => $user->getNomUtilisateur(),
            'prenomUtilisateur'=> $user->getPrenomUtilisateur(),
            'emailUtilisateur' => $user->getEmailUtilisateur(),
            'motDePasseUtilisateur' => $user->getMotDePasseUtilisateur(),
            'idImage' => $user->getIdImage()
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
}
?>