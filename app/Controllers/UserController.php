<?php
namespace app\Controllers;

use app\Factories\UserFactory;
use app\Factories\ArtistFactory;

class UserController {
    protected $userFactory;
    protected $artistFactory;

    public function __construct(UserFactory $userFactory, ArtistFactory $artistFactory) {
        $this->userFactory = $userFactory;
        $this->artistFactory = $artistFactory;
    }

    public function profile() {
        // get id $_SESSION['user_id'] -> $id -> $user = $this->userFactory->getUserById($id);
        require_once 'app/Views/user/profile.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userFactory->getUserByEmail($_POST['email']);
            if ($user != []) {
                if ($_POST['password'] == $user[0]->getMotDePasseUtilisateur()) {
                    $_SESSION['user_id'] = $user[0]->getIdUtilisateur();
                    if ($this->userFactory->getRole($user[0]->getIdUtilisateur()) == 1) {
                        $_SESSION['artist_id'] = $this->userFactory->getArtistId($user[0]->getIdUtilisateur());
                    }
                    header('Location: /');
                }
                else {
                    header('Location: /login');
                }
            }
            else {
                header('Location: /login');
            }
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            global $main;
            global $css;
            $main = require_once __DIR__ . '/../Views/user/login.php';
            $css = "login";
            require_once __DIR__ . '/../../public/index.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) and $_FILES['image']['error'] == 0) {
                if ($_FILES['image']['size'] <= 1900000) {
                    $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
                }
                else {
                    $image = base64_encode(file_get_contents('images/profile.png'));
                }
            }
            else {
                $image = base64_encode(file_get_contents('images/profile.png'));
            }
            $id_user = $this->userFactory->createUser($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $image);
            if ($_POST['nom-artiste'] != '') {
                $id_artist = $this->artistFactory->createArtist($_POST['nom-artiste'], '');
                $this->userFactory->addRole($id_user, 1, $id_artist);
            }
            else {
                $this->userFactory->addRole($id_user, 2, null);
            }
            header('Location: /login');
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            global $main;
            global $css;
            $main = require_once __DIR__ . '/../Views/user/register.php';
            $css = "register";
            require_once __DIR__ . '/../../public/index.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
    }

    public function update(int $id) {
        return null;
    }

    public function delete(int $id) {
        return null;
    }

    public function create() {
        // artist (case cochée ? + nom d'artiste ?) ? -> create artist + create user ?
        // user -> create user ?
        return null;
    }
}
?>