<?php
session_start();

require('connexion.php');
require('utile.php');
$connexion = connexionBd();


// Vérifiez si le paramètre 'id' est présent dans l'URL
if(isset($_GET['id'])){
    $numArticle= $_GET['id'];
    $sql= 'SELECT * from article where id_article =:id';
    $sql1=$connexion->prepare($sql);
    $sql1->bindParam(":id", $numArticle , PDO::PARAM_INT);
    $resultat=$sql1->execute();
    $result=$sql1->fetchAll(PDO::FETCH_ASSOC);
    $result=$result[0];
}
else {
    echo"Aucun Article trouvé " ;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
     <link href="css/style.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

     <!-- HEADER-->
     <?php  require ('header.php'); ?>

     <article id='detail-produit'>
     <p><header><h2 class="ss-titre"><?=$result["designation"]?></h2></header></p>
    <p><img src="<?=$result['img_article']?>" alt="<?=$result['designation']?>"></p>
    <p><?=tronquer_texte($result['description'])?></p>
    <p align='right'><strong>prix : <?=$result['prix']?>£</strong></p>


             <!-- le formulaire-->
             <p>
                <form action="ajouter_pannier.php" method="post" id="form-produit">
                    <input type="hidden" name="id_article" value="<?= $result['id_article'] ?>">
                    <label for="choix">Quantité</label>
                    <select name="nombre" id="nombre">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="4">5</option>
                    </select>
                    <label for="enregistrer">Enregistrer</label>
                    <input type="Submit" name="submit" value="Ajouter au panier" >
                </form>
             </p>




     </article>
     
        <!-- FOOTER -->
        <?php require ('footer.php'); ?>
</body>
</html>