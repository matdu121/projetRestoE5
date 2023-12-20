<?php
use modele\dao\Bdd;
use modele\dao\RestoDAO;

/**
 * Contrôleur listeRestos
 * Gère l'affichage de la liste de tous les restaurants
 * 
 * @version 09/2021 par NC
 */
Bdd::connecter();

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=recherche&critere=nom","label"=>"Recherche par nom");
$menuBurger[] = Array("url"=>"./?action=recherche&critere=adresse","label"=>"Recherche par adresse");
$menuBurger[] = Array("url" => "./?action=recherche&critere=multi", "label" => "Recherche multicritère");
$menuBurger[] = Array("url" => "./?action=recherche&critere=type", "label" => "Recherche par type de cuisine");

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 
$listeRestos =  RestoDAO::getAll();


// Construction de la vue
$titre = "Liste des restaurants répertoriés";
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/vueListeRestos.php";
require_once "$racine/vue/pied.html.php";

?>


