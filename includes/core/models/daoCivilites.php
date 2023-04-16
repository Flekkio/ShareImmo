<?php

	require_once "includes/core/models/bdd.php";
	require_once "includes/core/models/Civilite.php";

	//Fonction qui exécute le SELECT ... FROM civilite et renvoie le résultat sous la forme attendue
	function getAllCivilites(): array{
		$conn = getConnexion();

		$SQLQuery = "SELECT id, libelle_court, libelle_long FROM civilite";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->execute();

		$listeCivilites = array();

		while ($SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC)){
			$uneCivilite = new Civilite($SQLRow['libelle_court'], $SQLRow['libelle_long']);
			
			$uneCivilite->setId($SQLRow['id']);

			$listeCivilites[] = $uneCivilite;
				
		}
		$SQLStmt->closeCursor();
		return $listeCivilites;
	}

	function getCiviliteById(int $id): Civilite{
		$conn = getConnexion();

		$SQLQuery = "SELECT id, libelle_court, libelle_long 
			FROM civilite
			WHERE id = :id";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);
		$SQLStmt->execute();

		$SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
		$uneCivilite = new Civilite($SQLRow['libelle_court'], $SQLRow['libelle_long']);
		$uneCivilite->setId($SQLRow['id']);
		
		$SQLStmt->closeCursor();
		return $uneCivilite;
	}

	function getOneCivilite(int $id): Civilite{
    $conn = getConnexion();

    $SQLQuery = "SELECT id, libelle_court, libelle_long 
        FROM civilite
        WHERE id = :id";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);
    $SQLStmt->execute();

    $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    $uneCivilite = new Civilite($SQLRow['libelle_court'], $SQLRow['libelle_long']);
    $uneCivilite->setId($SQLRow['id']);

    $SQLStmt->closeCursor();
    return $uneCivilite;
}




