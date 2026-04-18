<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

// Récupération des articles
$sql = "SELECT * FROM article ORDER BY id_article DESC";
$stmt = $connexion->prepare($sql);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Gestion des produits</title>
</head>

<body>


    <?php require('sidebar.php'); ?>

        <!-- 🟩 CONTENU PRINCIPAL DÉCALÉ -->
        <div class="content">
        <section id="corps">

            <h2>Gestion des produits</h2>

            <a href="ajouter_produit.php" class="btn-add">➕ Ajouter un produit</a>
            <a href="index.php" class="btn-back">⬅ Retour au tableau de bord</a>

            <table class="admin-table">
                <tr>
                    <th>ID</th>
                    <th>Désignation</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>

                <?php foreach($articles as $a): ?>
                <tr>
                    <td><?= $a['id_article'] ?></td>
                    <td><?= $a['designation'] ?></td>
                    <td><?= $a['prix'] ?> €</td>
                    <td><img src="../<?= $a['img_article'] ?>" width="60"></td>
                    <td>
                        <a class="btn-edit" href="modifier_produit.php?id=<?= $a['id_article'] ?>">Modifier</a>
                        <a class="btn-delete" href="supprimer_produit.php?id=<?= $a['id_article'] ?>"
                        onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

        </section>
        </div>

</body>
</html>
