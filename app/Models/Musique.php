<?php
namespace app\Models;

class Musique {
    private int $idMusique;
    private string $nomMusique;
    private $descriptionMusique;
    private $dataMusique;
    private $idImage;

    public function __construct(int $idMusique, string $nomMusique, $descriptionMusique, $dataMusique, $idImage) {
        $this->idMusique = $idMusique;
        $this->nomMusique = $nomMusique;
        $this->descriptionMusique = $descriptionMusique;
        $this->dataMusique = $dataMusique;
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
    
    public function getDataMusique() {
        return $this->dataMusique;
    }
}
?>