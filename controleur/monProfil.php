<?php
use modele\dao\Bdd;
use modele\dao\UtilisateurDAO;

/**
 * Contrôleur monProfil
 * Page d'affichage des caractéristiques d'un utilisateur
 * 
 * Vue contrôlée : vueMonProfil
 * Données GET : 
 * 
 * @version 07/2021 intégration couche modèle objet
 * @version 08/2021 gestion erreurs
 */


Bdd::connecter();

// Récupération des données GET, POST, et SESSION

// Récupération des données utilisées dans la vue 
// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=profil","label"=>"Consulter mon profil");
$menuBurger[] = Array("url"=>"./?action=updProfil","label"=>"Modifier mon profil");

// Construction de la vue
$titre = "Mon profil";
if (isLoggedOn()){
    // Si un utilisateur est connecté
    // Données spécifiques à la page vueMonProfil
    $idU = getIdULoggedOn();
    $mailU = getMailULoggedOn();
    $util = UtilisateurDAO::getOneById($idU);   
    $mesRestosAimes = $util->getLesRestosAimes();
    $CuisinePref = $util->getCuisinePref();//dans le controleur on recupère les cuisines prefs des users 
   
    // Construction de la vue
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/vueMonProfil.php";
 }
else{
    // Si un aucun utilisateur n'est connecté
    // Construction de la vue
    ajouterMessage("Profil : aucun utilisateur n'est connecté");
    require_once "$racine/vue/entete.html.php";
}
require_once "$racine/vue/pied.html.php";

?>