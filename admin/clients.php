<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

// Récupération des clients
$sql = "SELECT * FROM client ORDER BY id_client DESC";
$stmt = $connexion->prepare($sql);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../images/favicon.ico" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Gestion des clients</title>
</head>

<body>


    <?php require('sidebar.php'); ?>


    <div class="content">
    <section id="corps">

    <h2>Gestion des clients</h2>

    <a href="index.php" class="btn-back">⬅ Retour au tableau de bord</a>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>

        <?php foreach($clients as $c): ?>
        <tr>
            <td><?= $c['id_client'] ?></td>
            <td><?= $c['nom'] ?></td>
            <td><?= $c['prenom'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['tel'] ?></td>
            <td><?= $c['role'] ?></td>
            <td>
                <a class="btn-edit" href="modifier_clients.php?id=<?= $c['id_client'] ?>">Modifer</a>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>

</section>
</div>

</body>
</html>
