<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

$message = "";

// Vérifier si un ID est fourni
if (!isset($_GET['id'])) {
    die("ID du produit manquant.");
}

$id = intval($_GET['id']);

// Récupérer le produit
$sql = "SELECT * FROM article WHERE id_article = :id";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Produit introuvable.");
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $designation = trim($_POST['designation']);
    $prix = trim($_POST['prix']);
    $tva = trim($_POST['tva']);
    $description = trim($_POST['description']);
    $categorie = trim($_POST['categorie']);

    if (empty($designation) || empty($prix) || empty($tva) || empty($description) || empty($categorie)) {
        $message = "Veuillez remplir tous les champs.";
    } else {

        // Si une nouvelle image est uploadée
        if (!empty($_FILES['image']['name'])) {

            $dossier = "../images/magasin/";
            $fichier = basename($_FILES['image']['name']);
            $chemin = $dossier . $fichier;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin)) {
                $img_article = "images/magasin/" . $fichier;
            } else {
                $message = "Erreur lors de l'upload de l'image.";
            }

        } else {
            // Garder l'ancienne image
            $img_article = $article['img_article'];
        }

        if (empty($message)) {
            // Mise à jour SQL
            $sql = "UPDATE article 
                    SET id_categorie = :cat, designation = :des, prix = :prix, tva = :tva, 
                        description = :descr, img_article = :img
                    WHERE id_article = :id";

            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(":cat", $categorie);
            $stmt->bindParam(":des", $designation);
            $stmt->bindParam(":prix", $prix);
            $stmt->bindParam(":tva", $tva);
            $stmt->bindParam(":descr", $description);
            $stmt->bindParam(":img", $img_article);
            $stmt->bindParam(":id", $id);

            if ($stmt->execute()) {
                header("Location: produits.php");
                exit();
            } else {
                $message = "Erreur lors de la mise à jour.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Modifier un produit</title>
</head>

<body>
<section id="corps">
    <h2>Modifier un produit</h2>

    <?php if (!empty($message)) : ?>
        <p style="color:red;"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="admin-form">

        <label>Désignation :</label>
        <input type="text" name="designation" value="<?= $article['designation'] ?>" required>

        <label>Prix :</label>
        <input type="number" step="0.01" name="prix" value="<?= $article['prix'] ?>" required>

        <label>TVA :</label>
        <input type="number" step="0.01" name="tva" value="<?= $article['tva'] ?>" required>

        <label>Description :</label>
        <textarea name="description" required><?= $article['description'] ?></textarea>

        <label>Catégorie :</label>
        <select name="categorie" required>
            <option value="1" <?= $article['id_categorie']==1 ? "selected" : "" ?>>Vêtements</option>
            <option value="2" <?= $article['id_categorie']==2 ? "selected" : "" ?>>Accessoires</option>
            <option value="3" <?= $article['id_categorie']==3 ? "selected" : "" ?>>Posters</option>
            <option value="4" <?= $article['id_categorie']==4 ? "selected" : "" ?>>DVD</option>
        </select>

        <label>Image actuelle :</label>
        <img src="../<?= $article['img_article'] ?>" width="100">

        <label>Nouvelle image (optionnel) :</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" class="btn-add">Mettre à jour</button>

    </form>
        <a href="index.php" class="btn-back">⬅ Retour au tableau de bord</a>

</section>
</body>
</html>


