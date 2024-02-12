<?php
namespace app\Models;

class Playlist {
    private int $idPlaylist;
    private string $nomPlaylist;
    private string|null $descriptionPlaylist;

    public function __construct(int $idPlaylist, string $nomPlaylist, string | null $descriptionPlaylist) {
        $this->idPlaylist = $idPlaylist;
        $this->nomPlaylist = $nomPlaylist;
        $this->descriptionPlaylist = $descriptionPlaylist;
    }

    public function getIdPlaylist(): int {
        return $this->idPlaylist;
    }

    public function getNomPlaylist(): string {
        return $this->nomPlaylist;
    }

    public function getDescriptionPlaylist(): string | null {
        return $this->descriptionPlaylist;
    }
}
?>