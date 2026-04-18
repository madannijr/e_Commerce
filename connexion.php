<?php 
// connexion a la BDD
define("SERVEUR","localhost");
define("USER","root");
define("MDP","");
define("BD","vente");

// gestion de connexion
function connexionBd($hote=SERVEUR, $username=USER, $mdp=MDP, $bd= BD){


try
  {
       $connexion= new PDO('mysql:host='.$hote.';dbname='.$bd, $username, $mdp);
      $connexion->exec("SET CHARACTER SET utf8");	// les accents
      return $connexion ;
 }
// gestion des erreurs

catch(Exception $e)
 {
        echo 'Erreur : '.$e->getMessage().'<br />';
       echo 'N° : '.$e->getCode();
}


}





?>