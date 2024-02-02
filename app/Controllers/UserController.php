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
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        }
    }

    public function logout() {
        return null;
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