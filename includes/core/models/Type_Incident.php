<?php
class Type_Incident{
	private int $id;
	private string $libelle;

	public function __construct(string $libelle = ''){
		$this->libelle = $libelle;
		$this->id = 0;
	}

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getLibelle(): string{
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void{
        $this->libelle = $libelle;
    }
}