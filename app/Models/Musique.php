<?php
namespace app\Models;

class Musique {
    private int $idMusique;
    private string $nomMusique;
    private $descriptionMusique;
    private $idImage;

    public function __construct(int $idMusique, string $nomMusique, $descriptionMusique, $idImage) {
        $this->idMusique = $idMusique;
        $this->nomMusique = $nomMusique;
        $this->descriptionMusique = $descriptionMusique;
        $this->idImage = $idImage;
    }

    public function getIdMusique(): int {
        return $this->idMusique;
    }

    public function getNomMusique(): string {
        return $this->nomMusique;
    }

    public function getDescriptionMusique() {
        return $this->descriptionMusique;
    }

    public function getIdImage() {
        return $this->idImage;
    }
}
?>