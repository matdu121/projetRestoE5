<?php
use modele\dao\Bdd;
/**
 * Contrôleur cgu
 * Page des Conditions Générales d'Utilisation
 * 
 * Vue contrôlée : vueCgu
 */

// Récupération des données GET, POST, et SESSION
//
// Récupération des données utilisées dans la vue 
Bdd::connecter();

$titre = "r3st0.fr - Conditions générales d'utilisations";

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"#top","label"=>"Conditions générales");
$menuBurger[] = Array("url"=>"#accpt","label"=>"Acceptation");
$menuBurger[] = Array("url"=>"#desc","label"=>"Description");
$menuBurger[] = Array("url"=>"#fonc","label"=>"Fonctionnalités");
$menuBurger[] = Array("url"=>"#mode","label"=>"Modération");
$menuBurger[] = Array("url"=>"#sanc","label"=>"Sanctions");
$menuBurger[] = Array("url"=>"#moti","label"=>"Motifs");
$menuBurger[] = Array("url"=>"#foncr","label"=>"Restaurateurs");
$menuBurger[] = Array("url"=>"#gene","label"=>"Généralités");
$menuBurger[] = Array("url"=>"#prot","label"=>"Données personnelles");
$menuBurger[] = Array("url"=>"#droi","label"=>"Droits d'accès");
$menuBurger[] = Array("url"=>"#util","label"=>"Données personnelles");
$menuBurger[] = Array("url"=>"#bila","label"=>"Bilan des fonctionnalités");



// Construction de la vue
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/vueCgu.php";
require_once "$racine/vue/pied.html.php";


?>