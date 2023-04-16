<?php

switch ($action) {
   case 'upload': {
      require_once "includes/core/models/daoUpload.php";
      require_once "includes/core/models/daoClients.php";

      $id = isset($_GET['id']) ? intval($_GET['id']) : null;
      $leClient = getOneClient($id);

      if (isset($_POST['submit'])) {
         $id = isset($_POST['id']) ? intval($_POST['id']) : null;
         if (!isset($_FILES['fileUpload']['error']) || is_array($_FILES['fileUpload']['error']) || !isset($_FILES['fileUpload']['tmp_name']) || empty($_FILES['fileUpload']['tmp_name'])) {
            $message = "Veuillez sélectionner un fichier.";
         } else {
            $fileType = $_FILES['fileUpload']['type'];
            if ($fileType !== 'application/pdf') {
               $message = "Seuls les fichiers PDF sont autorisés.";
            } else {
               $unDocument = new Document(
                  $_FILES['fileUpload']['name'],
                  $id,
                  file_get_contents($_FILES['fileUpload']['tmp_name'])
               );

               if (fileUpload($unDocument)) {
                  header("Location: ?page=agent&action=view&id=$id");
               } else {
                  $message = "Erreur d'enregistrement !";
               }
            }
         }
      }

      require_once "includes/core/views/vue_upload.phtml";
      break;
   }
}