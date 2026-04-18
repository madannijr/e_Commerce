<?php
session_start();
// verification si l'utilisateur est connecté
if(!isset($_SESSION['id_client'])) {
    header('Location: login.php');
    exit();
}

require('connexion.php');
$connexion = connexionBd();

// Si panier vide retour 
if(empty($_SESSION['panier'])) {
    header('Location: panier.php');
    exit();
}

$total = 0 ;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>Commande</title>
</head>
<body>
    <?php require('header.php'); ?>
    <section id="corps">
        <header><h2>Votre Commande</h2></header>

        <table id="cart-table">
            <tr>
                <td>Article</td>
                <td>Designation</td>
                <td>Quantité</td>
                <td>Prix</td>
                <td>Total</td>
            </tr>
            <?php foreach($_SESSION['panier'] as $id => $qtite) {
                $sql = "SELECT * FROM article WHERE id_article = :id";
                $sql1 = $connexion->prepare($sql);
                $sql1->bindParam(":id", $id, PDO::PARAM_INT);
                $sql1->execute();
                $article = $sql1->fetch(PDO::FETCH_ASSOC);

                if(!$article) continue ;
                $sous_total = $article['prix'] * $qtite ;
                $total += $sous_total ;
            ?>
                <tr>
                    <td><img src="<?= $article['img_article'] ?>" alt="<?= $article['designation'] ?>" width="80"></td>
                    <td><?= $article['designation'] ?></td>
                    <td><?= $qtite ?></td>
                    <td><?= $article['prix'] ?></td>
                    <td><?= $sous_total ?></td>
                </tr>

            <?php
            }  ?>

        </table>
            <p id="total-achat">
                <strong style="color: green;" 
                >Total à payer : <?= $total ?></strong>
            </p>

                <h3 style="text-align: center;">Informations Client </h3>
                <form action="valider_commande.php" method="post" style="text-align: center;">
                   <div>
                     <label for="">Nom :</label>
                     <input type="text" name="nom" required>
                   </div>
                   <div>
                        <label for="">Prenom :</label>
                        <input type="text" name="prenom" required>
                   </div>
                   <div>
                        <label for="">Adresse :</label>
                        <input type="text" name="adresse" required>
                   </div>
                   <div>
                        <label for="">Email :</label>
                        <input type="email" name="email" required>
                   </div>
                    <div>
                        <input type="submit" value="Valider la commande"
                            style="background: #8ea800; color: white; padding: 8px 15px; border-radius: 4px;"
                        >
                    </div>
                </form>
                </section>

                 <?php require('footer.php'); ?>
 
</body>
</html>