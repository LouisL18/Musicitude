<?php
namespace app\Factories;

use app\Models\Artist;
use PDO;

class AlbumFactory {
    protected $pdo = $pdo;

    public function getAllArtistes() {
        $stmt = $this->pdo->query('SELECT * FROM ARTISTE');
        return $stmt->fetchAll(PDO::FETCH_CLASS, Artist::class);
    }
}
?>