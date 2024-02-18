<?php
namespace app\Models;

class Album {
    private int $idAlbum;
    private string $nomAlbum;
    private string|null $descriptionAlbum;
    private int $anneeAlbum;
    private int $idArtiste;
    private int|null $idImage;

    public function __construct(int $idAlbum, string $nomAlbum, string|null $descriptionAlbum, int $anneeAlbum, int $idArtiste, int|null $idImage) {
        $this->idAlbum = $idAlbum;
        $this->nomAlbum = $nomAlbum;
        $this->descriptionAlbum = $descriptionAlbum;
        $this->anneeAlbum = $anneeAlbum;
        $this->idArtiste = $idArtiste;
        $this->idImage = $idImage;
    }

    public function getIdAlbum(): int {
        return $this->idAlbum;
    }

    public function getNomAlbum(): string {
        return $this->nomAlbum;
    }

    public function getDescriptionAlbum(): string|null {
        return $this->descriptionAlbum;
    }

    public function getAnneeAlbum(): int {
        return $this->anneeAlbum;
    }

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    public function getIdImage(): int|null {
        return $this->idImage;
    }
}
?>