<?php 
namespace app\Models;

class Genre  {
    private int $idGenre;
    private string $nomGenre;
    private string|null $descriptionGenre;

    public function __construct(int $idGenre, string $nomGenre, string|null $descriptionGenre) {
        $this->idGenre = $idGenre;
        $this->nomGenre = $nomGenre;
        $this->descriptionGenre = $descriptionGenre;
    }

    public function getIdGenre(): int {
        return $this->idGenre;
    }

    public function getNomGenre(): string {
        return $this->nomGenre;
    }

    public function getDescriptionGenre(): string|null {
        return $this->descriptionGenre;
    }
}
?>