<?php

class ReservationForm extends Model
{
    protected string $nom;
    protected string $email;
    protected int $chambreId;
    protected string $dateDebut;
    protected string $dateFin;

    public function setNom(string $nom): void
    {
        $this->nom = htmlspecialchars($nom);
    }

    public function setEmail(string $email): void
    {
        $this->email = htmlspecialchars($email);
    }

    public function setChambreId($chambreId): void
    {
        $this->chambreId = intval($chambreId);
    }

    public function setDateDebut(string $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin(string $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getChambreId(): int
    {
        return $this->chambreId;
    }

    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function getDateFin()
    {
        return $this->dateFin;
    }

}