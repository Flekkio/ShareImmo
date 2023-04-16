<?php 

if(!isset($_SESSION['client'])) {
    // Redirection vers la page de login si l'utilisateur n'est pas authentifié en tant qu'agent
    header('Location: ?page=users&action=login');
    exit;
}

	switch ($action){
		case 'main':{
			require_once "includes/core/models/daoClients.php";

			$client = $_SESSION['client'];
			$id = $client->getId();

			require_once "includes/core/views/vue_client.phtml";
			break;
		}

		case 'profil': {
    require_once "includes/core/models/daoClients.php";

    $client = $_SESSION['client'];
    $id = $client->getId();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldPassword = $_POST['old-password'];
        $newPassword = $_POST['new-password'];
        $currentPassword = $client->getPassword();
        if (password_verify($oldPassword, $currentPassword)) {
            // Hasher le nouveau mot de passe
            $newPasswordHash = hashPassword($newPassword);
            
            if (editClientPassword($newPasswordHash, $id)) {
                // Mettre à jour le mot de passe dans l'objet client
                $client->setPassword($newPasswordHash);

                header('Location: ?page=client&action=main');
                exit();
            } else {
                $errorMessage = "La modification du mot de passe a échoué. Veuillez réessayer.";
            }
        } else {
            $errorMessage = "L'ancien mot de passe ne correspond pas. Veuillez réessayer.";
        }
    }

    require_once "includes/core/views/infos_client.phtml";
    break;
}



		case 'document':{
			require_once "includes/core/models/daoClients.php";

			$client = $_SESSION['client'];
			$id = $client->getId();
			$lesDocuments = getAllDocuments($id);
			
			require_once "includes/core/views/document_client.phtml";
			break;
		}

        case 'incident':{
			require_once "includes/core/models/daoClients.php";
            require_once "includes/core/models/daoIncident.php";

            $client = $_SESSION['client'];
			$id = $client->getId();
			$nombreIncident = countIncident($id);
			$allIncidents = getAllIncidents();

			if (empty($_POST)){
				$unIncident = new Incident();
			}else{
				$unIncident = new Incident(
					genererRef(),
					 $_POST['chTitre'],
					 $_POST['chCommentaire'],
					getIncidentById($_POST['cbType']),
					getOneClient($id)
				);

				if (insertIncident($unIncident)){
					header('Location: ?page=client&action=incident');
				}else{
					$message = "Erreur d'enregistrement !";
				}
			}
			$lesIncidents = getAllType();
			$voirIncidents = showAllIncidents($id);

			require_once "includes/core/views/incident_client.phtml";
			break;
		}

		case 'close': {
		require_once "includes/core/models/daoIncident.php";
		
		$id = $_GET['id'];
		$closeIncident = closeIncident($id);
		$statut = showStatut($id);

		if ($closeIncident) {
			
			header('Location: ?page=client&action=incident');
			exit();
		} else {
        
			$errorMessage = "La suppression de l'incident a échoué. Veuillez réessayer.";
			require_once "includes/core/views/incident_client.phtml";
				}
			break;
		}
	}