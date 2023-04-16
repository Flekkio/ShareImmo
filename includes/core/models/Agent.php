<?php

class Agent{
    private int $id;
    private string $nom, $prenom;
    private $type = 'agent';

    public function __construct(string $nom = '', string $prenom = ''){
            $this->nom = $nom;
            $this->prenom = $prenom;
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
}