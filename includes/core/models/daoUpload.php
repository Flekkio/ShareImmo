<?php

require_once "includes/core/models/bdd.php";
require_once "includes/core/models/Document.php";

function fileUpload(Document $newDocument): bool {
    $conn = getConnexion();

    $SQLQuery = "INSERT INTO documents(nom_Document, id_Client, fichier)
                 VALUES (:nom_Document, :id_Client, :fichier)";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':nom_Document', $newDocument->getNom(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':id_Client', $newDocument->getIdClient(), PDO::PARAM_INT);
    $SQLStmt->bindValue(':fichier', $newDocument->getFichier(), PDO::PARAM_LOB);

    if (!$SQLStmt->execute()){
        return false;
    } else {
        return true;
    }
}