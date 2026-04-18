<?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['id_client']) || $_SESSION['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}
?>