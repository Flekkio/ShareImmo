<?php
require_once "Civilite.php";

class Client{
    private int $id;
    private string $nom, $prenom, $numRue, $nomRue, $ville, $mail, $telephone, $commentaire, $username, $password;
    private Civilite $civilite;
    private $type = 'client';

    public function __construct(string $nom = '', string $prenom = '',
        string $numRue = '', string $nomRue = '', Civilite $civilite = null,
        string $ville = '', string $mail = '', string $telephone = '', string $commentaire = '',
        string $username = '', string $password = ''){
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->numRue = $numRue;
            $this->nomRue = $nomRue;
            $this->ville = $ville;
            $this->civilite = $civilite?? new Civilite();
            $this->mail = $mail;
            $this->telephone = $telephone;
            $this->commentaire = $commentaire;
            $this->username = $username;
            $this->password = $password;
    }

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function setNom(string $nom): void{
        $this->nom = $nom;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void{
        $this->prenom = $prenom;
    }

    public function getNumRue(): string{
        return $this->numRue;
    }

    public function setNumRue(string $numRue): void{
        $this->numRue = $numRue;
    }

    public function getNomRue(): string{
        return $this->nomRue;
    }

    public function setNomRue(string $nomRue): void{
        $this->nomRue = $nomRue;
    }

    public function getVille(): string{
        return $this->ville;
    }

    public function setVille(string $ville): void{
        $this->ville = $ville;
    }

    public function getCivilite(): Civilite{
        return $this->civilite;
    }

    public function setCivilite(Civilite $civilite): void{
        $this->civilite = $civilite;
    }

    public function getMail(): string{
        return $this->mail;
    }

    public function setMail(string $mail): void{
        $this->mail = $mail;
    }

    public function getTelephone(): string{
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void{
        $this->telephone = $telephone;
    }

    public function getCommentaire(): string{
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): void{
        $this->commentaire = $commentaire;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function setUsername(string $username): void{
        $this->username = $username;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function setPassword(string $password): void{
        $this->password = $password;
    }

}