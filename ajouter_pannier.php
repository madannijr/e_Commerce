<?php
session_start();
require('connexion.php');
$connexion = connexionBd();

// Création du panier s'il n'existe pas
if(!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [] ;
}

// Traitement du formulaire "Ajouter au panier"
if($_SERVER["REQUEST_METHOD"] == 'POST') {

    // On récupère l'id de l'article et la quantité
    $id_article = $_POST['id_article'];
    $quantite = intval($_POST['nombre']);

    // Ajout ou mise à jour de la quantité dans le panier
    if(isset($_SESSION['panier'][$id_article])) {
        $_SESSION['panier'][$id_article] += $quantite ;
    } else {
        $_SESSION['panier'][$id_article] = $quantite ;
    }

    // 🔥 Retourner à la page précédente (produits, catégorie, etc.)
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
    }

    // Si quelqu'un accède à ce fichier sans POST, retour propre
    header("Location: index.php");
    exit();
?>
