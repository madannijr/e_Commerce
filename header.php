<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- HEADER-->
<header>
    <h1><a href="index.php">LIF|DESIGNSHOP</a></h1>

    <form id="search" action="recherche.php" method="post" enctype="multipart/form-data">
        <p>
            <input id="searchText" name="query" type="text" placeholder="Rechercher" />
            <input id="searchBtn" type="submit" class="bouton" value="OK" />
        </p>
    </form>

    <nav id="menu">

        <?php if(isset($_SESSION['id_client'])) : ?>
            <span style="color: white; margin-top: 20px; text-align: center;">
                Bonjour, <?= $_SESSION['prenom'] ?> <?= $_SESSION['nom'] ?>
            </span>
        <?php endif; ?>

        <ul>
            <li><a href="index.php">accueil</a></li>

            <?php if(!isset($_SESSION['id_client'])) : ?>
                <li><a href="login.php">Se connecter</a></li>
                <li><a href="creer_compte.php">créer compte</a></li>
            <?php else : ?>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>

            <li><a href="mes_commandes.php">Mes commandes</a></li>

            <li><a href="panier.php">panier
                <?php 
                if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
                    echo "(" . array_sum($_SESSION['panier']) . ")";
                } else {
                    echo "(0)";
                }
                ?>
            </a></li>
        </ul>
    </nav>

    <nav id="menu-categorie">   
        <ul>
            <li class="smenu"><a href="produits.php">tous les produits</a></li>
            <li class="smenu"><a href="categorie.php?cat=1">vetements</a></li>
            <li class="smenu"><a href="categorie.php?cat=2">accessoires</a></li>
            <li class="smenu"><a href="categorie.php?cat=3">posters</a></li>
            <li class="smenu"><a href="categorie.php?cat=4">dvd</a></li>
        </ul>
    </nav>
</header>
