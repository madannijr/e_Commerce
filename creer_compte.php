<?php

session_start();
require('connexion.php');
$connexion = connexionBd();

// Message erreur ou de succès 
$message = " ";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Nettoyage des données
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $tel = trim($_POST['tel']);
    $mdp = trim($_POST['mdp']);

    // Vérification de remplissage 
    if(empty($nom) || empty($prenom) || empty($email) || empty($tel) || empty($mdp)) {
        $message = "Veuillez remplir tous les champs.";
    }
    else {

        // Vérification si l'email existe déjà 
        $sql = "SELECT * FROM client WHERE email = :email";
        $sql1 = $connexion->prepare($sql);
        $sql1->bindParam(":email", $email);
        $sql1->execute();

        if($sql1->rowCount() > 0) {
            $message = "Cet email existe déjà.";
        } else {

            // Insérer le nouveau client 
            $insert = "INSERT INTO client (nom, prenom, email, tel, mdp, role) 
           VALUES (:nom, :prenom, :email, :tel, :mdp, 'client')";

            $insert1 = $connexion->prepare($insert);

            $insert1->bindParam(":nom", $nom);
            $insert1->bindParam(":prenom", $prenom);
            $insert1->bindParam(":email", $email);
            $insert1->bindParam(":tel", $tel);
            $insert1->bindParam(":mdp", $mdp);

            if($insert1->execute()) {
                $message = "Votre compte a été créé avec succès.";
            } else {
                $message = "Erreur lors de la création du compte.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/favicon.ico" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>Créer un compte</title>
</head>
<body>

    <?php require('header.php'); ?>

    <section id="corps">
        <h2>Créer un compte</h2>

        <form action="creer_compte.php" method="post" id="creer-compte">

            <div>
                <label>Nom :</label>
                <input type="text" name="nom" required>
            </div>

            <div>  
                <label>Prénom :</label>
                <input type="text" name="prenom" required>
            </div>

            <div>
                <label>Email :</label>
                <input type="email" name="email" required>
            </div>

            <div>
                <label>Téléphone :</label>
                <input type="number" name="tel" required>
            </div>

            <div>
                <label>Mot de passe :</label>
                <input type="password" name="mdp" required>
            </div>

            <div>
                <input type="checkbox" required> Accepter les conditions d'utilisation
            </div>

            <div style="margin-bottom: 10px;">
                <input type="submit" value="Créer un compte">
            </div>

        </form>
        
        <?php if(!empty($message)) : ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?> 
    </section>

    <?php require('footer.php'); ?>

</body>
</html>
