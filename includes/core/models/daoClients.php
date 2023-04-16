<?php

	require_once "includes/core/models/bdd.php";
	require_once "includes/core/models/Client.php";
	require_once "includes/core/models/Document.php";

	function getAllClients(): array{
		$conn = getConnexion();

		$SQLQuery = "SELECT c.id, c.nom, c.prenom, c.numero_rue, c.nom_rue, c.ville, c.mail, c.telephone, c.commentaire,
				civ.libelle_court, civ.libelle_long
			FROM client c INNER JOIN civilite civ ON c.id_Civilite = civ.id";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->execute();

		$listeClients = array();
        while ($SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC)){
			$commentaire = isset($SQLRow['commentaire']) && is_string($SQLRow['commentaire']) ? $SQLRow['commentaire'] : '';
			$unClient = new Client ($SQLRow['nom'], $SQLRow['prenom'], $SQLRow['numero_rue'],
				$SQLRow['nom_rue'], new Civilite ($SQLRow['libelle_court'], $SQLRow['libelle_long']), $SQLRow['ville'], $SQLRow['mail'], 
				$SQLRow['telephone'], $commentaire);

				$unClient->setId($SQLRow['id']);

			$listeClients[] = $unClient;
				
		}

		$SQLStmt->closeCursor();

		return $listeClients;
	}

	function getOneClient(int $id): ?Client {
    $conn = getConnexion();

    $SQLQuery = "SELECT c.id, c.nom, c.prenom, c.numero_rue, c.nom_rue, c.ville, c.mail, c.telephone, c.commentaire,
				civ.libelle_court, civ.libelle_long
			FROM client c INNER JOIN civilite civ ON c.id_Civilite = civ.id
			WHERE c.id = :id";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $SQLStmt->execute();

    $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);

    if (!$SQLRow) {
        return null; // aucun client trouvé
    }

    $commentaire = isset($SQLRow['commentaire']) && is_string($SQLRow['commentaire']) ? $SQLRow['commentaire'] : '';
    $unClient = new Client ($SQLRow['nom'], $SQLRow['prenom'], $SQLRow['numero_rue'],
        $SQLRow['nom_rue'], new Civilite ($SQLRow['libelle_court'], $SQLRow['libelle_long']), $SQLRow['ville'], $SQLRow['mail'], 
        $SQLRow['telephone'], $commentaire);
	$unClient->setId($id);
    return $unClient;
}


	function insertContact(Client $newClient): bool {
		
		$conn = getConnexion();

		$SQLQuery = "INSERT INTO client(nom, prenom, numero_rue, nom_rue, ville, 
		id_Civilite, mail, telephone, commentaire, username, password)
		VALUES (:nom, :prenom, :numero_rue, :nom_rue, :ville, :id_Civilite, :mail, :telephone, :commentaire, :username, :password)";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindValue(':nom', $newClient->getNom(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':prenom', $newClient->getPrenom(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':numero_rue', $newClient->getNumRue(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':nom_rue', $newClient->getNomRue(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':ville', $newClient->getVille(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':id_Civilite', $newClient->getCivilite()->getId(), PDO::PARAM_INT);
		$SQLStmt->bindValue(':mail', $newClient->getMail(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':telephone', $newClient->getTelephone(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':commentaire', $newClient->getCommentaire(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':username', $newClient->getUsername(), PDO::PARAM_STR);
		$SQLStmt->bindValue(':password', $newClient->getPassword(), PDO::PARAM_STR);

		$isInserted = $SQLStmt->execute();

    if ($isInserted) {
        // Récupération de l'ID auto-incrémenté du client ajouté
        $lastInsertedId = $conn->lastInsertId();
        $newClient->setId($lastInsertedId);
    }

    return $isInserted;
	}

	function viewPass(int $id): array {
    $conn = getConnexion();
    $SQLQuery = "SELECT username, password FROM client WHERE id = :id";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);
    $SQLStmt->execute();
    return $SQLStmt->fetch(PDO::FETCH_ASSOC);
	}


function createLogin($prenom, $nom){
	$login = strtolower(substr($prenom, 0, 1) . $nom);
	return $login;
	}

function createPassword(){
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < 6; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
	}

	function deleteClient(int $id): bool {
    $conn = getConnexion();

    $SQLQuery = "DELETE FROM client WHERE id = :id";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindParam(':id', $id, PDO::PARAM_INT);

    if (!$SQLStmt->execute()) {
        return false;
    }

    return $SQLStmt->rowCount() > 0;
}

function editClient(Client $updatedClient, int $id): bool {
    $conn = getConnexion();

    $SQLQuery = "UPDATE client SET nom = :nom, prenom = :prenom, numero_rue = :numero_rue, nom_rue = :nom_rue, ville = :ville,
                    id_Civilite = :id_Civilite, mail = :mail, telephone = :telephone, commentaire = :commentaire
                WHERE id = :id";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':nom', $updatedClient->getNom(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':prenom', $updatedClient->getPrenom(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':numero_rue', $updatedClient->getNumRue(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':nom_rue', $updatedClient->getNomRue(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':ville', $updatedClient->getVille(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':id_Civilite', $updatedClient->getCivilite()->getId(), PDO::PARAM_INT);
    $SQLStmt->bindValue(':mail', $updatedClient->getMail(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':telephone', $updatedClient->getTelephone(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':commentaire', $updatedClient->getCommentaire(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);

    if (!$SQLStmt->execute()) {
        return false;
    }

    return $SQLStmt->rowCount() > 0;
}

function getAllDocuments(int $id): array{
		$conn = getConnexion();

		$SQLQuery = "SELECT *
			FROM documents d INNER JOIN client cli ON d.id_Client = cli.id
			WHERE cli.id = :id";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindParam(':id', $id, PDO::PARAM_INT);
		$SQLStmt->execute();

		$listeDocuments = array();
        while ($SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC)){
			$unDocument = new Document($SQLRow['nom_Document'], (int) $SQLRow['id_Client'], $SQLRow['fichier']);


				$unDocument->setId($SQLRow['id']);

			$listeDocuments[] = $unDocument;
				
		}

		$SQLStmt->closeCursor();

		return $listeDocuments;
}

function editClientPassword(string $newPassword, int $id): bool {
    $conn = getConnexion();

    $SQLQuery = "UPDATE client SET password = :password WHERE id = :id";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':password', $newPassword, PDO::PARAM_STR);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);

    if (!$SQLStmt->execute()) {
        return false;
    }

    return $SQLStmt->rowCount() > 0;
}

function hashPassword(string $password): string{
	
	return password_hash($password, PASSWORD_DEFAULT);
	}
