<?php
require_once "includes/core/models/Agent.php";
require_once "includes/core/models/Client.php";
session_start();
$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

switch ($page){
    case 'index':{
        if (!isset($_SESSION['username'])) {
            header('Location: ?page=users&action=login');
            exit();
        }
        require_once "includes/core/controllers/controller.php";
        break;
    }
    case 'users':{
        require_once "includes/core/controllers/controller_login.php";
        break;
    }
    case 'agent':{
        switch ($action) {
        case 'upload':
            require_once "includes/core/controllers/controller_upload.php";
            break;
        default:
            require_once "includes/core/controllers/controller_agent.php";
            break;
    }
    
    break;
    }

    case 'client':{
        require_once "includes/core/controllers/controller_client.php";
        break;
    }
    
    default:{
        require_once "includes/core/controllers/controller_error.php";
    }
}