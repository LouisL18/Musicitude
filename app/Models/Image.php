<?php 
namespace app\Models;

class Image {
    private int $idImage;
    private string|null $nomImage;
    private $dataImage;

    public function __construct(int $idImage, string|null $nomImage, $dataImage) {
        $this->idImage = $idImage;
        $this->nomImage = $nomImage;
        $this->dataImage = $dataImage;
    }

    public function getIdImage(): int {
        return $this->idImage;
    }

    public function getNomImage(): string|null {
        return $this->nomImage;
    }

    public function getDataImage() {
        return $this->dataImage;
    }
}
?>