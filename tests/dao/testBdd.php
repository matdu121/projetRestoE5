<?php

use modele\dao\Bdd;
require_once '../../includes/autoload.inc.php';

try{
$cnx = Bdd::connecter();
echo "Valeur de Bdd::estConnecte() après connexion :";
var_dump(Bdd::estConnecte());
Bdd::deconnecter();
echo "Valeur de Bdd::estConnecte() après déconnexion :";
var_dump(Bdd::estConnecte());
}catch(PDOException $ex){
    echo "*** échec de la connexion à la BDD *** : ".$ex->getMessage();
}