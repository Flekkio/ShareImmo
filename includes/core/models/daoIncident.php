<?php

	require_once "includes/core/models/bdd.php";
    require_once "includes/core/models/Client.php";
    require_once "includes/core/models/Incident.php";
	require_once "includes/core/models/Type_Incident.php";

	function getAllType(): array{
		$conn = getConnexion();

		$SQLQuery = "SELECT ID, libelle FROM type_incident";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->execute();

		$listeIncidents = array();

		while ($SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC)){
			$unIncident = new Type_Incident($SQLRow['libelle']);
			
			$unIncident->setId($SQLRow['ID']);

			$listeIncidents[] = $unIncident;
				
		}
		$SQLStmt->closeCursor();
		return $listeIncidents;
	}

	function getIncidentById(int $id): Type_Incident{
		$conn = getConnexion();

		$SQLQuery = "SELECT ID, libelle 
			FROM type_incident
			WHERE ID = :ID";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindValue(':ID', $id, PDO::PARAM_INT);
		$SQLStmt->execute();

		$SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
		$unIncident = new Type_Incident($SQLRow['libelle']);
		$unIncident->setId($SQLRow['ID']);
		
		$SQLStmt->closeCursor();
		return $unIncident;
	}

    function getOneType(int $id): Type_Incident{
    $conn = getConnexion();

    $SQLQuery = "SELECT ID, libelle 
        FROM type_incident
        WHERE ID = :ID";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':ID', $id, PDO::PARAM_INT);
    $SQLStmt->execute();

    $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    $unIncident = new Type_Incident($SQLRow['libelle']);
    $unIncident->setId($SQLRow['ID']);

    $SQLStmt->closeCursor();
    return $unIncident;
}

function genererRef(): string {
    $date = date('YmdHis');
    $rand = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    return "INC-{$date}-{$rand}";
}

function insertIncident(Incident $newIncident): bool {
		
		$conn = getConnexion();
        $ref = genererRef();

		$SQLQuery = "INSERT INTO incident(ref, titre_incident, commentaire, ID_type_incident, id_Client, statut)
		VALUES (:ref, :titre_incident, :commentaire, :ID_type_incident, :id_Client, :statut)";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindValue(':ref', $ref, PDO::PARAM_STR);
		$SQLStmt->bindValue(':titre_incident', $newIncident->getTitre(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':commentaire', $newIncident->getCommentaire(), PDO::PARAM_STR);
        $SQLStmt->bindValue(':ID_type_incident', $newIncident->getTypeIncident()->getId(), PDO::PARAM_INT);
        $SQLStmt->bindValue(':id_Client', $newIncident->getClient()->getId(), PDO::PARAM_INT);
		$SQLStmt->bindValue(':statut', $newIncident->getStatut(), PDO::PARAM_STR);

		if (!$SQLStmt->execute()){
			return false;
		}else{
			return true;
		}
	}

	function countIncident(int $id): int{
    $conn = getConnexion();

    $SQLQuery = "SELECT COUNT(*) FROM incident WHERE id_Client = :id_client AND statut = 'open'";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_client', $id, PDO::PARAM_INT);
    $SQLStmt->execute();
    return (int) $SQLStmt->fetchColumn();
}


function showAllIncidents(int $id_client): array {
    $conn = getConnexion();

    $SQLQuery = "SELECT ID, ref, titre_incident, commentaire, statut, ID_type_incident 
        FROM incident 
        WHERE id_Client = :id_client";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_client', $id_client, PDO::PARAM_INT);
    $SQLStmt->execute();

    $listeIncidents = array();

    while ($SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC)){
        $typeIncident = getIncidentById($SQLRow['ID_type_incident']);
        $client = getOneClient($id_client);
        $unIncident = new Incident($SQLRow['ref'], $SQLRow['titre_incident'], $SQLRow['commentaire'], $typeIncident, $client);

        $unIncident->setId($SQLRow['ID']);

        $listeIncidents[] = $unIncident;
    }

    $SQLStmt->closeCursor();
    return $listeIncidents;
}

function closeIncident(string $id): bool {
    $conn = getConnexion();

    $SQLQuery = "UPDATE incident SET statut = 'close' WHERE id = :id";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_STR);

    $result = $SQLStmt->execute();
    $SQLStmt->closeCursor();
    return $result;
}

function showStatut(string $id): string {
    $conn = getConnexion();

    $SQLQuery = "SELECT statut FROM incident WHERE id = :id";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_STR);
    $SQLStmt->execute();

    $statut = $SQLStmt->fetch(PDO::FETCH_ASSOC)['statut'];

    $SQLStmt->closeCursor();
    return $statut;
}

function getAllIncidents(): array {
    $conn = getConnexion();

    $SQLQuery = "SELECT ID, ref, titre_incident, commentaire, statut, ID_type_incident, id_Client 
        FROM incident";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->execute();

    $allIncidents = array();

    while ($SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC)){
        $typeIncident = getIncidentById($SQLRow['ID_type_incident']);
        $client = getOneClient($SQLRow['id_Client']);
        $unIncident = new Incident($SQLRow['ref'], $SQLRow['titre_incident'], $SQLRow['commentaire'], $typeIncident, $client);

        $unIncident->setId($SQLRow['ID']);

        $allIncidents[] = $unIncident;
    }

    $SQLStmt->closeCursor();
    return $allIncidents ?? array();
}