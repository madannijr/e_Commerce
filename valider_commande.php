<?php
session_start();
require('connexion.php');
$connexion = connexionBd();

// Si panier vide → retour
if (empty($_SESSION['panier'])) {
    header('Location: panier.php');
    exit();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit();
}

$id_client = $_SESSION['id_client'];

// Récupération des informations du client
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];

// Enregistrement de la commande AVEC id_client
$sql = "INSERT INTO commande (id_client, nom_client, prenom_client, adresse, email, date_commande)
        VALUES (:idc, :nom, :prenom, :adresse, :email, NOW())";

$req = $connexion->prepare($sql);
$req->bindParam(":idc", $id_client);
$req->bindParam(":nom", $nom);
$req->bindParam(":prenom", $prenom);
$req->bindParam(":adresse", $adresse);
$req->bindParam(":email", $email);
$req->execute();

// ID de la commande
$id_commande = $connexion->lastInsertId();

// Enregistrement des articles
foreach ($_SESSION['panier'] as $id => $qtite) {

    $sql = "INSERT INTO commande_article (id_commande, id_article, quantite)
            VALUES (:idc, :ida, :qte)";

    $req = $connexion->prepare($sql);
    $req->bindParam(":idc", $id_commande);
    $req->bindParam(":ida", $id);
    $req->bindParam(":qte", $qtite);
    $req->execute();
}

// On vide le panier
    //unset($_SESSION['panier']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>Commande validée</title>
</head>
<body>

<?php require('header.php'); ?>

<section id="corps">
    <header><h2>Commande validée</h2></header>

    <p>Merci <strong><?= $prenom ?> <?= $nom ?></strong> !</p>
    <p>Votre commande n° <strong><?= $id_commande ?></strong> a été enregistrée.</p>
    <p>Un email de confirmation sera envoyé à <strong><?= $email ?></strong>.</p>
</section>

<?php require('footer.php'); ?>

</body>
</html>
