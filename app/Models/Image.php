<?php 
namespace app\Models;

class Image {
    private int $idImage;
    private string $nomImage;
    private $dataImage;

    public function __construct(int $idImage, string $nomImage, $dataImage) {
        $this->idImage = $idImage;
        $this->nomImage = $nomImage;
        $this->dataImage = $dataImage;
    }

    public function getIdImage(): int {
        return $this->idImage;
    }

    public function getNomImage(): string {
        return $this->nomImage;
    }

    public function getDataImage() {
        return $this->dataImage;
    }
}
?>