<?php
require('securite.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../images/favicon.ico" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Administration</title>
</head>
<body>

    <?php
    require('sidebar.php') ;
    ?>

<!-- CONTENU -->
<div class="content">
    <section id="corps">
        <h2>Tableau de bord Administrateur</h2>

        <div class="admin-grid">

            <div class="admin-card">
                <img src="../images/icon-products.png" alt="">
                <a href="produits.php">Gérer les produits</a>
            </div>

            <div class="admin-card">
                <img src="../images/icon-orders.png" alt="">
                <a href="commandes.php">Gérer les commandes</a>
            </div>

            <div class="admin-card">
                <img src="../images/icon-users.png" alt="">
                <a href="clients.php">Gérer les clients</a>
            </div>

        </div>
    </section>
</div>

</body>
</html>
