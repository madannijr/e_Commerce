<?php	
session_start();
require('connexion.php'); // inclusion du fichier de la connexion de la BD
$connexion=connexionBd(); // creer le point de connexion

//requete
$requete = "SELECT * FROM article ORDER BY RAND() LIMIT 6";
$requetes=$connexion->query($requete);
$result=$requetes->fetchall();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="images/favicon.ico" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <title>openSHOP : Accueil</title>
    </head>
    <body>


        <!-- HEADER-->
        <?php  require ('header.php'); ?>

        <!-- CONTENU -->

        <section>
            <header>Bienvenue <span class="ss-titre">Nous sommes LIF|DISIGN </span></header>
            <p>La boutique en ligne <strong>openSHOP</strong> est un travail réalisé par <em>DIALLO</em> &amp; <em>LIF|DISIGN </em> .</p>
            <p>Dans la partie haute, vous trouverez un moyen pour vous identifiez ou créer un compte si vous n'en n'avez aucun. Le champ de recherche 
                vous permet d'afficher simplement les produits correspondants à ce que vous souhaitez. Vous pouvez aussi naviguer entre les différentes 
                catégorie de produits en cliquant sur celle que vous désirez voir.</p>
            <p>Bonne naviguation !</p>
        </section>
        <section id="corps">
            <header><h2>Au hasard...</h2></header>
            <ul id="product-list">
                <!-- affichage des articles -->  
                <?php require('utile.php'); ?>  
                <!--                       -->
            <?php foreach($result as $articl): ?>
                <li class="product">
                   <h3><?=$articl['designation'];?></h3>
                   <p><img src="<?=$articl["img_article"]?>" alt="<?=$articl["designation"]?>"> </p>
                   <p>prix:<?=$articl["prix"];?>£</p>
                   <p><?=tronquer_texte($articl['description']);?></p>
                   <p><a href="vue_produit.php?id=<?=$articl['id_article'];?>">voir les details</a></p>
                </li>
            <?php endforeach; ?>
            </ul>
        </section>



        <!-- FOOTER -->
       <?php require ('footer.php'); ?>

    </body>
</html>