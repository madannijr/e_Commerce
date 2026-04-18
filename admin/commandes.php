<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

// Récupération des commandes
$sql = "SELECT id_commande, id_client, nom_client, prenom_client, email, date_commande
        FROM commande
        ORDER BY id_commande DESC";

$stmt = $connexion->prepare($sql);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../images/favicon.ico" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Gestion des commandes</title>
</head>

<body>

            <?php require('sidebar.php'); ?>


            <!-- CONTENU PRINCIPAL -->
            <div class="content">
            <section id="corps">

            <h2>Gestion des commandes</h2>

            <a href="index.php" class="btn-back">⬅ Retour au tableau de bord</a>

            <table class="admin-table">
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>

            <?php foreach($commandes as $cmd): ?>
            <tr>
            <td><?= $cmd['id_commande'] ?></td>
            <td><?= $cmd['prenom_client'] . " " . $cmd['nom_client'] ?></td>
            <td><?= $cmd['email'] ?></td>
            <td><?= $cmd['date_commande'] ?></td>
            <td>
                <a class="btn-edit" href="details_commande.php?id=<?= $cmd['id_commande'] ?>">
                    Voir détails
                </a>
            </td>
            </tr>
        <?php endforeach; ?>
        </table>

</section>
</div>

</body>
</html>
