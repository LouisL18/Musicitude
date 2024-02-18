<?php
namespace app\Models;

class Artist {
    private int $idArtiste;
    private string $nomArtiste;
    private string|null $descriptionArtiste;

    public function __construct(int $idArtiste, string $nomArtiste, string|null $descriptionArtiste) {
        $this->idArtiste = $idArtiste;
        $this->nomArtiste = $nomArtiste;
        $this->descriptionArtiste = $descriptionArtiste;
    }

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    public function getNomArtiste(): string {
        return $this->nomArtiste;
    }

    public function getDescriptionArtiste(): string|null {
        return $this->descriptionArtiste;
    }
}
?>