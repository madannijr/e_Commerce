<?php
session_start();
require('connexion.php');
$connexion = connexionBd();
$total = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>Panier</title>
</head>
<body>

<?php require('header.php'); ?>

<section id="corps">
    <header><h2>Votre Panier</h2></header>

    <?php if(empty($_SESSION['panier'])) : ?>

        <div id="empty-cart">Votre panier est vide</div>

    <?php else : ?>

        <table id="cart-table"> 
            <tr>
                <th>Image</th>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php foreach($_SESSION['panier'] as $id => $qtite) {

                $sql = "SELECT * FROM article WHERE id_article = :id";
                $sql1 = $connexion->prepare($sql);
                $sql1->bindParam(":id", $id, PDO::PARAM_INT);
                $sql1->execute();
                $article = $sql1->fetch(PDO::FETCH_ASSOC);

                // Si l'article n'existe pas en base
                if(!$article) continue;

                $sous_total = $article['prix'] * $qtite;
                $total += $sous_total;
            ?>

            <tr>
                <td><img src="<?= $article['img_article'] ?>" alt="<?= $article['designation'] ?>" width="80"></td>
                <td><?= $article['designation'] ?></td>
                <td><?= $qtite ?></td>
                <td><?= $article['prix'] ?> £</td>
                <td><?= $sous_total ?> £</td>
                <td><a href="supprimer.php?id=<?= $id ?>" style="color: red;">Supprimer</a></td>
            </tr>

            <?php } ?>

        </table>

        <p id="total-achat">
            <strong>Total du panier : <?= $total ?> £</strong>
        </p>

            <div>
                 <p style="text-align:left; margin-left: 40px;">
                <a href="commande.php"
                style="background: #8ea800; color: white; padding: 8px 15px; border-radius: 4px;">
                        Passer la commande</a>
            </p>
            </div>

           <div>
             <p style="text-align:right; margin-right:40px;">
            <a href="vider_panier.php" 
            style="background:#b30000; color:white; padding:8px 15px; border-radius:4px;">
            Vider le panier
            </a>
           </div>
</p>

    <?php endif; ?>

</section>

<?php require('footer.php'); ?>

</body>
</html>
