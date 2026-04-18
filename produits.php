<?php
session_start();

 require('connexion.php');
 require('utile.php');
 $connexion = connexionBd();

 // recuperer tous les produits 
 $sql = "SELECT * FROM article ORDER BY designation ASC";
 $sql1 = $connexion->query($sql);
 $produits = $sql1->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <title>Tous les produits - openSHOP</title>
</head>
<body>
    <?php require('header.php'); ?>

    <section id="corps">
        <header><h2>Tous les produits</h2></header>

        <ul id="product-list">
            <?php foreach($produits as $produit) : ?>
                <li class="product">
                    <h3>
                        <?= $produit['designation'] ?>
                    </h3>
                        <p><img src="<?=$produit['img_article'] ?>" alt="<?= $produit['designation'] ?>"></p>
                        <p>Prix : <?= $produit['prix'] ?></p>
                        <p><?= tronquer_texte($produit['designation']) ?></p>

                      <div class="actions-produit">
    
                            <form action="ajouter_pannier.php" method="post">
                                <input type="hidden" name="id_article" value="<?= $produit['id_article'] ?>">
                                <input type="hidden" name="nombre" value="1">
                                <input type="submit" value="Ajouter au panier" class="btn-panier">
                            </form>

                            <a href="vue_produit.php?id=<?= $produit['id_article']; ?>" class="btn-details">
                                Voir les détails
                            </a>

                        </div>

                          
                </li>

            <?php endforeach; ?>    
        </ul>

    </section>
    <?php require('footer.php') ?>
</body>
</html>