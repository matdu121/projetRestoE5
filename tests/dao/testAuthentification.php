<?php

use modele\dao\Bdd;

require_once '../../includes/autoload.inc.php';
require_once "../../includes/authentification.inc.php";       // gestion des sessions authentifiées

Bdd::connecter();
// test d'authentification applicative
//login("mathieu.capliez@gmail.com", "Passe1?");
$mailU = "test@bts.sio";
echo "Tentative de connexion de $mailU<br/>";
login($mailU, "sio");
if (isLoggedOn()) {
    echo "Ok, $mailU is logged<br/>";
} else {
    echo "Problème, $mailU is not logged<br/>";
}

// deconnexion
echo "Tentative de déconnexion<br/>";
logout();
if (isLoggedOn()) {
    echo "Problème, $mailU is always logged<br/>";
} else {
    echo "Ok, $mailU is no more logged<br/>";
}


echo "Tentative de connexion avec un login inexistant<br/>";
$mailU = "inconnu@bts.sio";
login($mailU, "1234");
if (isLoggedOn()) {
    echo "Problème, $mailU ne devrait pas être connecté<br/>";
} else {
    echo "Ok, $mailU n'est pas connecté<br/>";
}



