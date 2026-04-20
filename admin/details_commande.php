<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

// Vérifier l'ID de commande
if (!isset($_GET['id'])) {
    die("ID de commande manquant.");
}

$id_commande = intval($_GET['id']);

    // Récupérer les infos de la commande 
    $sql = "SELECT c.*, cl.tel
            FROM commande c
            LEFT JOIN client cl ON c.id_client = cl.id_client
            WHERE c.id_commande = :id";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(":id", $id_commande);
    $stmt->execute();
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$commande) {
        die("Commande introuvable.");
    }

        // Récupérer les articles de la commande
        $sql = "SELECT ca.quantite, a.prix, a.designation, a.img_article
                FROM commande_article ca
                JOIN article a ON ca.id_article = a.id_article
                WHERE ca.id_commande = :id";

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(":id", $id_commande);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Détails commande</title>
</head>

<body>
<section id="corps">

    <h2>Détails de la commande #<?= $commande['id_commande'] ?></h2>

    <a href="commandes.php" class="btn-back">⬅ Retour aux commandes</a>

    <h3>Informations client</h3>

    <!-- Bloc stylé par ton fichier CSS -->
    <div class="info-client">
        <p><strong>Nom :</strong> <?= $commande['prenom_client'] . " " . $commande['nom_client'] ?></p>
        <p><strong>Email :</strong> <?= $commande['email'] ?></p>
        <p><strong>Téléphone :</strong> <?= $commande['tel'] ?></p>
        <p><strong>Adresse :</strong> <?= $commande['adresse'] ?></p>
        <p><strong>Date :</strong> <?= $commande['date_commande'] ?></p>
    </div>

            <h3>Articles commandés</h3>

            <table class="admin-table">
                <tr>
                    <th>Image</th>
                    <th>Désignation</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>

                <?php 
                $total_general = 0;
                foreach($articles as $a): 
                    $total_ligne = $a['prix'] * $a['quantite'];
                    $total_general += $total_ligne;
                ?>
                <tr>
                    <td><img src="../<?= $a['img_article'] ?>" width="60"></td>
                    <td><?= $a['designation'] ?></td>
                    <td><?= number_format($a['prix'], 2) ?> €</td>
                    <td><?= $a['quantite'] ?></td>
                    <td><?= number_format($total_ligne, 2) ?> €</td>
                </tr>
                <?php endforeach; ?>

                <tr>
                    <th colspan="4" style="text-align:right;">Total général :</th>
                    <th><?= number_format($total_general, 2) ?> €</th>
                </tr>
            </table>

        </section>
</body>
</html>
