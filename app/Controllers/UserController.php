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
        $user = $this->userFactory->getUserById($_SESSION['user_id']);
        if (isset($_SESSION['artist_id'])) {
            $artist = $this->artistFactory->getArtistById($_SESSION['artist_id']);
        }
        $super_user = [
            'User' => $user[0],
            'Image' => $this->userFactory->getImage($user[0]->getIdImage()),
        ];
        global $main;
        global $css;
        $main = require_once __DIR__ . '/../Views/user/profile.php';
        $css = "profile";
        require_once __DIR__ . '/../../public/index.php';
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userFactory->updateUser($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mot-de-passe'], $_FILES['image']['tmp_name'] != '' ? base64_encode(file_get_contents($_FILES['image']['tmp_name'])) : null);
            header('Location: /user');
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $user = $this->userFactory->getUserById($_SESSION['user_id']);
            if (isset($_SESSION['artist_id'])) {
                $artist = $this->artistFactory->getArtistById($_SESSION['artist_id']);
            }
            global $main;
            global $css;
            $main = require_once __DIR__ . '/../Views/user/edit.php';
            $css = "../../css/profile";
            require_once __DIR__ . '/../../public/index.php';
        }
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
                $image = base64_encode(file_get_contents('images/profile.png'));
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

    public function delete() {
        $this->userFactory->deleteUser();
        session_destroy();
        http_response_code(200);
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
    }
}
?>