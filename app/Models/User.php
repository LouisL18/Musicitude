<?php
namespace app\Models;

class User {
    private int $idUtilisateur;
    private string $nomUtilisateur;
    private string $prenomUtilisateur;
    private string $emailUtilisateur;
    private string $motDePasseUtilisateur;
    private int $idImage;

    public function __construct(int $idUtilisateur, string $nomUtilisateur, string $prenomUtilisateur, string $emailUtilisateur, string $motDePasseUtilisateur, int $idImage) {
        $this->idUtilisateur = $idUtilisateur;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->prenomUtilisateur = $prenomUtilisateur;
        $this->emailUtilisateur = $emailUtilisateur;
        $this->motDePasseUtilisateur = $motDePasseUtilisateur;
        $this->idImage = $idImage;
    }

    public function getIdUtilisateur(): int {
        return $this->idUtilisateur;
    }

    public function getNomUtilisateur(): string {
        return $this->nomUtilisateur;
    }

    public function getPenomUtilisateur(): string {
        return $this->prenomUtilisateur;
    }

    public function getEmailUtilisateur(): string {
        return $this->emailUtilisateur;
    }

    public function getMatDePasseUtilisateur(): string {
        return $this->motDePasseUtilisateur;
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
            </div>",
            $this->idUtilisateur,
            $this->nomUtilisateur,
            $this->prenomUtilisateur,
            $this->emailUtilisateur,
            $this->motDePasseUtilisateur,
            $this->idImage
        );
    }
}
?>