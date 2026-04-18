<?php
session_start();

// Si le panier existe, on le supprime entièrement
if (isset($_SESSION['panier'])) {
    unset($_SESSION['panier']);
}

// Retour au panier
header('Location: panier.php');
exit();

