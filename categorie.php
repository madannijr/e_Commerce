<?php
session_start();

require('connexion.php');
require('utile.php'); 

$connexion = connexionBd();

// Vérifier si une catégorie est demandée
if (!isset($_GET['cat'])) {
    die("<h2>❌ Aucune catégorie sélectionnée</h2>");
}

$idCat = $_GET['cat'];

// Récupérer le nom de la catégorie
$sqlCat = "SELECT nom FROM categorie WHERE id_categorie = :id";
$stmtCat = $connexion->prepare($sqlCat);
$stmtCat->bindParam(":id", $idCat, PDO::PARAM_INT);
$stmtCat->execute();
$categorie = $stmtCat->fetch(PDO::FETCH_ASSOC);

if (!$categorie) {
    die("<h2>❌ Catégorie introuvable</h2>");
}

// Récupérer les produits de cette catégorie
$sql = "SELECT * FROM article WHERE id_categorie = :id ORDER BY designation ASC";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(":id", $idCat, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <title><?= $categorie['nom'] ?> - openSHOP</title>
</head>
<body>

<?php require('header.php'); ?>

<section id="corps">
    <header><h2>Catégorie : <?= $categorie['nom'] ?></h2></header>

    <ul id="product-list">
        <?php foreach($articles as $art): ?>
            <li class="product">
                <h3><?= $art['designation']; ?></h3>

                <p><img src="<?= $art['img_article']; ?>" alt="<?= $art['designation']; ?>"></p>

                <p>Prix : <?= $art['prix']; ?>£</p>

                <p><?= tronquer_texte($art['description']); ?></p>
                <p>
                    <div class="actions-produit">

                        <form action="ajouter_pannier.php" method="post">
                            <input type="hidden" name="id_article" value="<?= $art['id_article'] ?>">
                            <input type="hidden" name="nombre" value="1">
                            <input type="submit" value="Ajouter au panier">
                        </form>

                        <a href="vue_produit.php?id=<?= $art['id_article']; ?>">
                            Voir les détails
                        </a>

                    </div>
                </p>

            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php require('footer.php'); ?>

</body>
</html>
