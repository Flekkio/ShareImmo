<?php

switch ($action) {
    case 'login': {
        require_once "includes/core/models/daoLogin.php";

        $message = ""; // initialiser la variable message

        if (!empty($_POST)) {
            $loginSaisi = $_POST['champLogin'];
            $mdpSaisi = $_POST['champMdp'];

            $conn = getConnexion();

            // Requête SQL avec UNION pour récupérer les informations de connexion à partir de deux tables différentes
            $SQLQuery = "
                SELECT id, password, 'agent' as type
                FROM agent
                WHERE username = :username
                UNION
                SELECT id, password, 'client' as type
                FROM client
                WHERE username = :username
            ";

            $SQLStmt = $conn->prepare($SQLQuery);
            $SQLStmt->bindValue(':username', $loginSaisi, PDO::PARAM_STR);
            $SQLStmt->execute();

            $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier si la requête a renvoyé un résultat ou non
            if (!$SQLRow) {
                $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            } else {
                $userId = $SQLRow['id'];
                $motDePasseStocke = $SQLRow['password'];
                $userType = $SQLRow['type'];

                $SQLStmt->closeCursor();

                if (substr($motDePasseStocke, 0, 4) !== '$2y$') {
                    $passwordHashe = hashPassword($motDePasseStocke);

                    $SQLQuery = "
                        UPDATE $userType
                        SET password = :password
                        WHERE id = :id
                    ";

                    $SQLStmt = $conn->prepare($SQLQuery);
                    $SQLStmt->bindValue(':password', $passwordHashe, PDO::PARAM_STR);
                    $SQLStmt->bindValue(':id', $userId, PDO::PARAM_INT);
                    $SQLStmt->execute();

                    $SQLStmt->closeCursor();

                    $motDePasseStocke = $passwordHashe;
                }

                if (checkAuth($loginSaisi, $mdpSaisi, $motDePasseStocke)) {
                    $_SESSION['username'] = $loginSaisi;

                    // Différencier les utilisateurs en fonction de leur type
                    if ($userType === 'agent') {
                        $_SESSION['agent'] = getOneAgent($userId);
                        header('Location: ?page=agent&action=list');
                    } else {
                        $_SESSION['client'] = getOneClient($userId);
                        header('Location: ?page=client&action=main');
                    }
                } else {
                    $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
                }
            }
        } 

        require_once "includes/core/views/login.phtml";
        break;
    }

    case 'logout': {
        if (isset($_SESSION['username'])) {
            unset($_SESSION['username']);

            // Supprimer les variables de session en fonction du type d'utilisateur
            if (isset($_SESSION['agent'])) {
                unset($_SESSION['agent']);
            } else {
                unset($_SESSION['client']);
            }
        }

        header('Location: index.php');
        break;
    }

    default: {

    }
}
