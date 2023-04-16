<?php
class Civilite{
	private int $id;
	private string $libelleCourt, $libelleLong;

	public function __construct(string $libelleCourt = '', string $libelleLong = ''){
		$this->libelleCourt = $libelleCourt ;
		$this->libelleLong = $libelleLong; 
		$this->id = 0;
	}

	public function getId(): int{
		return $this->id;
	}

	public function setId(int $id): void{
		$this->id = $id;
	}

	public function getLibelleCourt(): string{
		return $this->libelleCourt;
	}

	public function setLibelleCourt(string $libelleCourt): void{
		$this->libelleCourt = $libelleCourt;
	}

	public function getLibelleLong(): string{
		return $this->libelleLong;
	}

	public function setLibelleLong(string $libelleLong): void{
		$this->libelleLong = $libelleLong;
	}
}