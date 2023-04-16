<?php
require_once "Client.php";
require_once "Type_Incident.php";


class Incident{
    private int $id;
    private string $ref;
    private string $titre, $commentaire;
    private Type_Incident $type_incident;
    private Client $client;
    private string $statut = 'open';

    public function __construct(string $ref = '', string $titre = '', string $commentaire = '', Type_Incident $type_incident = null, Client $client = null){
        $this->ref = $ref;
        $this->titre = $titre;
        $this->commentaire = $commentaire;
        $this->type_incident = $type_incident ?? new Type_Incident();
        $this->client = $client?? new Client();
        $this->statut = 'open';
    }

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getRef(): string{
        return $this->ref;
    }

    public function setRef(string $ref): void{
        $this->ref = $ref;
    }

    public function getTitre(): string{
        return $this->titre;
    }

    public function setTitre(string $titre): void{
        $this->titre = $titre;
    }

    public function getCommentaire(): string{
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): void{
        $this->commentaire = $commentaire;
    }

    public function getStatut(): string{
        return $this->statut;
    }

    public function setStatut(string $statut): void{
        $this->statut = $statut;
    }

    public function getTypeIncident(): Type_Incident{
        return $this->type_incident;
    }

    public function setTypeIncident(Type_Incident $type_incident): void{
        $this->type_incident = $type_incident;
    }

    public function getClient(): Client{
        return $this->client;
    }

    public function setClient(Client $client): void{
        $this->client = $client;
    }
}
