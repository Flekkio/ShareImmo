<?php
	require_once "includes/core/models/bdd.php";
	require_once "includes/core/models/Agent.php";
	require_once "includes/core/models/Client.php";

	function userExists(string $username): bool{
		$conn = getConnexion();

		$SQLQuery = "
			SELECT COUNT(id) as existe
			FROM agent
			WHERE username = :username
			UNION
			SELECT COUNT(id) as existe
			FROM client
			WHERE username = :username
		";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindValue(':username', $username, PDO::PARAM_STR);
		$SQLStmt->execute();

		$SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
		$usernameTrouve = $SQLRow['existe'];
		
		$SQLStmt->closeCursor();

		return ($usernameTrouve > 0);
	}

	function hashPassword(string $password): string{
	
	return password_hash($password, PASSWORD_DEFAULT);
	}

	function checkAuth(string $username, string $password): bool{
		$conn = getConnexion();
		
		$SQLQuery = "
			SELECT password
			FROM agent
			WHERE username = :username	
			UNION
			select password
			FROM client
			WHERE username = :username
		";

		$SQLStmt = $conn->prepare($SQLQuery);
		$SQLStmt->bindValue(':username', $username, PDO::PARAM_STR);
		$SQLStmt->execute();

		$SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
		$motDePasseStocke = $SQLRow['password'];

		$SQLStmt->closeCursor();

		return (password_verify($password, $motDePasseStocke));

	}

	function insertUser(string $username, string $passwordHashed): bool{
    $conn = getConnexion();
    
    $SQLQuery = "
        INSERT INTO agent (username, password)
        VALUES (:username, :password)
		UNION
		INSERT INTO client (username, password)
		VALUES (:username, :password)
    ";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':username', $username, PDO::PARAM_STR);
    $SQLStmt->bindValue(':password', $passwordHashed, PDO::PARAM_STR);
    $resultatInsertion = $SQLStmt->execute();

    $SQLStmt->closeCursor();

    return $resultatInsertion;
}

function getOneAgent(int $id): ?Agent{
    $conn = getConnexion();

    $SQLQuery = "
        SELECT nom, prenom
        FROM agent
        WHERE id = :id
    ";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);
    $SQLStmt->execute();

    $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);

    if(!$SQLRow){
        return null;
    }

    $agent = new Agent();
    $agent->setId($id);
    $agent->setNom($SQLRow['nom']);
    $agent->setPrenom($SQLRow['prenom']);

    $SQLStmt->closeCursor();

    return $agent;
}

function getOneClient (int $id): ?Client{
	$conn = getConnexion();

	$SQLQuery = "
		SELECT nom, prenom, numero_rue, nom_rue, ville, mail, telephone, username, password
		FROM client
		WHERE id = :id
	";

	$SQLStmt = $conn->prepare($SQLQuery);
	$SQLStmt->bindValue(':id', $id, PDO::PARAM_INT);
	$SQLStmt->execute();

	$SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);

	if(!$SQLRow){
		return null;
	}

	$client = new Client();
	$client->setId($id);
	$client->setNom($SQLRow['nom']);
	$client->setPrenom($SQLRow['prenom']);
	$client->setNumRue($SQLRow['numero_rue']);
	$client->setNomRue($SQLRow['nom_rue']);
	$client->setVille($SQLRow['ville']);
	$client->setMail($SQLRow['mail']);
	$client->setTelephone($SQLRow['telephone']);
	$client->setUsername($SQLRow['username']);
	$client->setPassword($SQLRow['password']);

	$SQLStmt->closeCursor();

	return $client;
}