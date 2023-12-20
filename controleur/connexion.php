<?php
use modele\dao\Bdd;

/**
 * Contrôleur connexion
 * Traitement du formulaire d'authentification
 * 
 * Vue contrôlée : vueAuthentification ou redirection vers le contrôleur monProfil
 * @version 08/2021 gestion erreurs
 * 
 */

Bdd::connecter();

// Récupération des données GET, POST, et SESSION
// 
// Récupération des données utilisées dans la vue 
// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=connexion","label"=>"Connexion");
$menuBurger[] = Array("url"=>"./?action=inscription","label"=>"Inscription");

// Construction de la vue
// Si le formulaire n'est pas complètement saisi (en provenance d'une autre page que vueAuthentification  ...)
if (!isset($_POST["mailU"]) || !isset($_POST["mdpU"])){
    // on affiche simplement le formulaire de connexion
    $titre = "authentification";
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/vueAuthentification.php";
    require_once "$racine/vue/pied.html.php";
} else {
    // Sinon, on récupèrère les données POST du formulaire d'authentification
    $mailU=$_POST["mailU"];
    $mdpU=$_POST["mdpU"];
    
    // on tente l'authentification
    login($mailU,$mdpU);

    // Si l'utilisateur est connecté (authentification réussie)
    if (!isLoggedOn()){ 
        // sinon, la connexion a échoué, on ré-affiche le formulaire de connexion
        ajouterMessage("Connexion : erreur de login ou de mot de passe");
        $titre = "authentification";
        require_once "$racine/vue/entete.html.php";
        require_once "$racine/vue/vueAuthentification.php";
        require_once "$racine/vue/pied.html.php";
    } else{
        // on affiche le profil
        header('Location: ./?action=profil');
    }
}

?>