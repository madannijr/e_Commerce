<?php
require('securite.php');
require('../connexion.php');
$connexion = connexionBd();

if(!isset($_GET['id'])) {
    header("Location: clients.php");
    exit();
}

$id = $_GET['id'];

// Récupérer les infos du client
$sql = "SELECT * FROM client WHERE id_client = :id";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$client) {
    header("Location: clients.php");
    exit();
}

// Mise à jour
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $role = $_POST['role'];

    $sql2 = "UPDATE client 
             SET nom = :nom, prenom = :prenom, email = :email, tel = :tel, role = :role 
             WHERE id_client = :id";

    $stmt2 = $connexion->prepare($sql2);
    $stmt2->bindParam(":nom", $nom);
    $stmt2->bindParam(":prenom", $prenom);
    $stmt2->bindParam(":email", $email);
    $stmt2->bindParam(":tel", $tel);
    $stmt2->bindParam(":role", $role);
    $stmt2->bindParam(":id", $id);
    $stmt2->execute();

    header("Location: clients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/style1.css" rel="stylesheet" />
    <link href="../css/admin.css" rel="stylesheet" />

    <title>Modifier Client</title>
</head>
<body>

<?php require('sidebar.php'); ?>

<div class="content">
<section id="corps">

    <h2>Modifier le client</h2>

    <form method="post" class="form">

        <label>Nom :</label>
        <input type="text" name="nom" value="<?= $client['nom'] ?>" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= $client['prenom'] ?>" required>

        <label>Email :</label>
        <input type="email" name="email" value="<?= $client['email'] ?>" required>

        <label>Téléphone :</label>
        <input type="text" name="tel" value="<?= $client['tel'] ?>">

        <label>Rôle :</label>
        <select name="role">
            <option value="client" <?= $client['role'] == 'client' ? 'selected' : '' ?>>Client</option>
            <option value="admin" <?= $client['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <input type="submit" value="Enregistrer" class="btn-edit">

    </form>

</section>
</div>

</body>
</html>
