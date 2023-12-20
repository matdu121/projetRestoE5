<?php
use modele\dao\Bdd;

/**
 * Contrôleur deconnexion
 * Fin de la session authentifiée et retour à la page de connexion
 * 
 * Vue contrôlée : vueAuthentification
 * 
 */
// Récupération des données GET, POST, et SESSION
// 
// Récupération des données utilisées dans la vue 

Bdd::connecter();

$titre = "authentification";

// Fin de la ssession
logout();           

// Construction de la vue
$GLOBALS['isLoggedOn'] = false;
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/vueAuthentification.php";
require_once "$racine/vue/pied.html.php";
?>