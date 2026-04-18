<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

// Vérifier si un ID est fourni
if (!isset($_GET['id'])) {
    die("ID du produit manquant.");
}

$id = intval($_GET['id']);

// Supprimer le produit
$sql = "DELETE FROM article WHERE id_article = :id";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(":id", $id);

if ($stmt->execute()) {
    header("Location: produits.php");
    exit();
} else {
    echo "Erreur lors de la suppression.";
}
?>
