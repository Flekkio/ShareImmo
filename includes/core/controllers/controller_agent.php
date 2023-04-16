<?php 

if(!isset($_SESSION['agent'])) {
    // Redirection vers la page de login si l'utilisateur n'est pas authentifié en tant qu'agent
    header('Location: ?page=users&action=login');
    exit;
}

	switch ($action){
		case 'list':{
			require_once "includes/core/models/daoClients.php";
			$lesClients = getAllClients();
			$id = $_GET['id'] ?? 0;
			require_once "includes/core/views/vue_agent.phtml";
			break;
		}
		case 'add':{
			require_once "includes/core/models/daoClients.php";
			require_once "includes/core/models/daoCivilites.php";
			if (empty($_POST)){
				$unClient = new Client();
			}else{
				$unClient = new Client(
					$_POST['chNom'],
					$_POST['chPrenom'],
					$_POST['chNumRue'],
					$_POST['chNomRue'],
					getCiviliteById($_POST['cbCivilite']),
					$_POST['chVille'],
					$_POST['chMail'],
					$_POST['chTelephone'],
					$_POST['chCommentaire'],
					createLogin($_POST['chPrenom'], $_POST['chNom']),
					createPassword()
				);

				if (insertContact($unClient)){
					header('Location: ?page=agent&action=confirm&id='.$unClient->getId());
				}else{
					$message = "Erreur d'enregistrement !";
				}
			}
			$lesCivilites = getAllCivilites();

			require_once "includes/core/views/vue_ajout_client.phtml";
			break;
		}
		case 'confirm':{
			

			require_once "includes/core/models/daoClients.php";
			
			 $id = $_GET['id'] ?? 0;

			$leClientPass = viewPass($id);;

			require_once "includes/core/views/confirm.phtml";
			break;
		}
		case 'view':{
			require_once "includes/core/models/daoClients.php";
			require_once "includes/core/models/daoIncident.php";
			$lesClients = getAllClients();
			
			$id = $_GET['id'] ?? 0;
			$leClient = getOneClient($id);
			$nombreIncident = countIncident($id);

			require_once "includes/core/views/fiche_client.phtml";
			break;
		}
		case 'delete': {
		require_once "includes/core/models/daoClients.php";
		$id = $_GET['id'] ?? 0;
		$supprClient = deleteClient($id);

		if ($supprClient) {
			
			header('Location: ?page=agent&action=list');
			exit();
		} else {
        
			$errorMessage = "La suppression du client a échoué. Veuillez réessayer.";
			require_once "includes/core/views/fiche_client.phtml";
				}
			break;
		}
		case 'edit': {
	require_once "includes/core/models/daoClients.php";
	require_once "includes/core/models/daoCivilites.php";
	$id = $_GET['id'] ?? 0;
	
	$leClient = getOneClient($id);
	$lesCivilites = getAllCivilites();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Récupérer les nouvelles informations de l'utilisateur depuis le formulaire
		$updatedClient = new Client(
			$_POST['chNom'],
			$_POST['chPrenom'],
			$_POST['chNumRue'],
			$_POST['chNomRue'],
			getOneCivilite($_POST['cbCivilite']),
			$_POST['chVille'],
			$_POST['chMail'],
			$_POST['chTelephone'],
			$_POST['chCommentaire']
			
		);

		// Mettre à jour le client dans la base de données
		if (editClient($updatedClient, $id)) {
			header('Location: ?page=agent&action=list');
			exit();
		} else {
			$errorMessage = "La modification du client a échoué. Veuillez réessayer.";
		}
	}

	require_once "includes/core/views/modif_client.phtml";
	break;
}

case 'upload':{
	require_once "includes/core/models/daoClients.php";
			$id = $_GET['id'] ?? 0;
			$leClient = getOneClient($id);
			require_once "includes/core/views/vue_upload.phtml";
			break;
		}
		default:{

		}

		case 'document':{
			require_once "includes/core/models/daoClients.php";
            require_once "includes/core/models/daoIncident.php";
			
			$allIncidents = getAllIncidents();

			require_once "includes/core/views/document_agent.phtml";
			break;
		}

		case 'close': {
		require_once "includes/core/models/daoIncident.php";
		
		$id = $_GET['id'];
		$closeIncident = closeIncident($id);
		$statut = showStatut($id);

		if ($closeIncident) {
			
			header('Location: ?page=agent&action=incident');
			exit();
		} else {
        
			$errorMessage = "La suppression de l'incident a échoué. Veuillez réessayer.";
			require_once "includes/core/views/document_agent.phtml";
				}
			break;
		}
		
	}