<?php

echo "TEST LOGIN OK<br>";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
//session_start();

//require('connexion.php');
//$connexion = connexionBd();
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
                $_SESSION['role'] = $client['role']; // 🔥 important

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
