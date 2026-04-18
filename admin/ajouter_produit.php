<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $designation = trim($_POST['designation']);
    $prix = trim($_POST['prix']);
    $tva = trim($_POST['tva']);
    $description = trim($_POST['description']);
    $categorie = trim($_POST['categorie']);

    // Vérification des champs
    if (empty($designation) || empty($prix) || empty($tva) || empty($description) || empty($categorie)) {
        $message = "Veuillez remplir tous les champs.";
    } else {

        // Upload de l'image
        if (!empty($_FILES['image']['name'])) {

            $dossier = "../images/magasin/";
            $fichier = basename($_FILES['image']['name']);
            $chemin = $dossier . $fichier;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin)) {

                // On enregistre le chemin dans la base (sans ../)
                $img_article = "images/magasin/" . $fichier;

                // Insertion SQL
                $sql = "INSERT INTO article (id_categorie, designation, prix, tva, description, img_article)
                        VALUES (:cat, :des, :prix, :tva, :descr, :img)";

                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(":cat", $categorie);
                $stmt->bindParam(":des", $designation);
                $stmt->bindParam(":prix", $prix);
                $stmt->bindParam(":tva", $tva);
                $stmt->bindParam(":descr", $description);
                $stmt->bindParam(":img", $img_article);

                if ($stmt->execute()) {
                    header("Location: produits.php");
                    exit();
                } else {
                    $message = "Erreur lors de l'ajout du produit.";
                }

            } else {
                $message = "Erreur lors de l'upload de l'image.";
            }

        } else {
            $message = "Veuillez sélectionner une image.";
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
    <title>Ajouter un produit</title>
</head>

<body>
<section id="corps">
    <h2>Ajouter un produit</h2>

    <?php if (!empty($message)) : ?>
        <p style="color:red;"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="admin-form">

        <label>Désignation :</label>
        <input type="text" name="designation" required>

        <label>Prix :</label>
        <input type="number" step="0.01" name="prix" required>

        <label>TVA :</label>
        <input type="number" step="0.01" name="tva" required>

        <label>Description :</label>
        <textarea name="description" required></textarea>

        <label>Catégorie :</label>
        <select name="categorie" required>
            <option value="">-- Choisir --</option>
            <option value="1">Vêtements</option>
            <option value="2">Accessoires</option>
            <option value="3">Posters</option>
            <option value="4">DVD</option>
        </select>

        <label>Image :</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" class="btn-add">Ajouter</button>

    </form>
    
</section>
</body>
</html>
