<?php
namespace app\Models;

class Album {
    private int $idAlbum;
    private string $nomAlbum;
    private string $descriptionAlbum;
    private int $anneeAlbum;
    private int $idArtiste;
    private int $idImage;

    public function __construct(int $idAlbum, string $nomAlbum, string $descriptionAlbum, int $anneeAlbum, int $idArtiste, int $idImage) {
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

    public function getDescriptionAlbum(): string {
        return $this->descriptionAlbum;
    }

    public function getAnneeAlbum(): int {
        return $this->anneeAlbum;
    }

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    public function getIdImage(): int {
        return $this->idImage;
    }

    public function fullRender(): string {
        return sprintf(
            "<div>
                <p>%d</p>
                <p>%s</p>
                <p>%s</p>
                <p>%s</p>
                <p>%d</p>
                <p>%d</p>
            </div>",
            $this->idAlbum,
            $this->nomAlbum,
            $this->descriptionAlbum,
            $this->anneeAlbum,
            $this->idArtiste,
            $this->idImage
            );
    }

    public function listRender(): string {
        return sprintf(
            "<div>
                <p>%d</p>
                <p>%s</p>
                <p>%s</p>
                <p>%s</p>
                <p>%d</p>
                <p>%d</p>
            </div>",
            $this->idAlbum,
            $this->nomAlbum,
            $this->descriptionAlbum,
            $this->anneeAlbum,
            $this->idArtiste,
            $this->idImage
            );
    }
}
?>