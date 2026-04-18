<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require('connexion.php');
$connexion = connexionBd();
$message = "" ;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $mdp = trim($_POST['mdp']);

    if(empty($email) || empty($mdp)) {
        $message = "Veuillez remplir tous les champs.";
    } else {

        // Vérification si l'utilisateur existe
        $sql = "SELECT * FROM client WHERE email = :email";
        $sql1 = $connexion->prepare($sql);
        $sql1->bindParam(":email", $email);
        $sql1->execute();
        $client = $sql1->fetch(PDO::FETCH_ASSOC);

        if($client) {

            // Vérification du mot de passe
            if($mdp == $client['mdp']) {

                // Création de la session
                $_SESSION['id_client'] = $client['id_client'];
                $_SESSION['nom'] = $client['nom'];
                $_SESSION['prenom'] = $client['prenom'];
                $_SESSION['role'] = $client['role'];

                header("Location: index.php");
                exit();

            } else {
                $message = "Mot de passe incorrect.";
            }

        } else {
            $message = "Aucun compte trouvé. <a href='creer_compte.php'>Créer un compte</a>";
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
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <title>Connexion</title>
</head>
<body>

    <?php require('header.php'); ?>

    <section id="corps">

        <?php if(!empty($message)) : ?>
            <p style="color: red;"><?= $message ?></p>
        <?php endif; ?>

        <h2>Identification</h2>

        <form action="login.php" method="post" id="login">
            <div>
                <label>Email :</label>
                <input type="email" name="email" required>
            </div>

            <div>
                <label>Mot de Passe :</label>
                <input type="password" name="mdp" required>
            </div>

            <div>
                <input type="submit" value="Valider">
            </div>
        </form>

    </section>

    <?php require('footer.php'); ?>

</body>
</html>
