<?php 
    require_once "includes/core/models/daoClients.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['agent'])) {
        $lesClients = getAllClients();
        $id = $_GET['id'] ?? 0;
        require_once "includes/core/views/vue_agent.phtml";
    } elseif (isset($_SESSION['client'])) {
        $client = $_SESSION['client'];
        $id = $client->getId();
        require_once "includes/core/views/vue_client.phtml";
    }
?>
