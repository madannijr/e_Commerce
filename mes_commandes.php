<?php
session_start();
require('connexion.php');
$connexion = connexionBd();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit();
}

$id_client = $_SESSION['id_client'];

// Récupérer les commandes du client
$sql = "SELECT * FROM commande WHERE id_client = :id ORDER BY date_commande DESC";
$req = $connexion->prepare($sql);
$req->bindParam(":id", $id_client);
$req->execute();
$commandes = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>Mes commandes</title>
</head>
<body>

<?php require('header.php'); ?>

<section id="corps">
    <header><h2>Mes commandes</h2></header>

    <?php if (empty($commandes)) : ?>
        <p>Aucune commande trouvée.</p>
    <?php else : ?>

        <table id="cart-table">
            <tr>
                <th>ID Commande</th>
                <th>Date</th>
                <th>Montant total</th>
                <th>Action</th>
            </tr>

            <?php foreach ($commandes as $cmd) : ?>

                <?php
                // Calcul du total de la commande
                $sql2 = "SELECT SUM(a.prix * ca.quantite) AS total
                         FROM commande_article ca
                         JOIN article a ON ca.id_article = a.id_article
                         WHERE ca.id_commande = :idc";

                $req2 = $connexion->prepare($sql2);
                $req2->bindParam(":idc", $cmd['id_commande']);
                $req2->execute();
                $total = $req2->fetch(PDO::FETCH_ASSOC)['total'];
                ?>

                <tr>
                    <td><?= $cmd['id_commande'] ?></td>
                    <td><?= $cmd['date_commande'] ?></td>
                    <td><?= $total ?> €</td>
                    <td><a href="detail_commande.php?id=<?= $cmd['id_commande'] ?>">Voir détails</a></td>
                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</section>

<?php require('footer.php'); ?>

</body>
</html>
