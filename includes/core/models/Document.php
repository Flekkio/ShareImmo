<?php

class Document{
    private int $id;
    private string $nom, $fichier;
    private int $id_client;

    public function __construct(string $nom = '', int $id_client = 0, string $fichier = ''){
        $this->nom = $nom;
        $this->id_client = $id_client;
        $this->fichier = $fichier;
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

    public function getIdClient(): int{
        return $this->id_client;
    }

    public function setIdClient(int $id_client): void{
        $this->id_client = $id_client;
    }

    public function getFichier(): string{
        return $this->fichier;
    }

    public function setFichier(string $fichier): void{
        $this->fichier = $fichier;
    }
}