<?php

use modele\dao\Bdd;
use modele\dao\UtilisateurDAO;
use modele\metier\Utilisateur;

/**
 * Contrôleur inscription
 * Gestion du formulaire d'inscription
 * 
 * Vue contrôlée : vueInscription et vueConfirmationInscription
 * Données POST : mailU, mdpU, pseudoU si le formulaire est validé
 * 
 * Lorsque que le formulaire est vide (1er affichage) ou incomplet : $inscriptionReussie = false
 * 
 * @version 07/2021 intégration couche modèle objet
 * @version 08/2021 gestion erreurs
 */
Bdd::connecter();

$inscriptionReussie = false;   // booléen indiquant s'il faut afficher le formulaire ou bien confirmer l'inscription
// Données à transmettre à la vue
$titre = "";                    // titre de la vue
// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url" => "./?action=connexion", "label" => "Connexion");
$menuBurger[] = Array("url" => "./?action=inscription", "label" => "Inscription");

// Récupération des données GET, POST, et SESSION
if (isset($_POST["mailU"]) && isset($_POST["mdpU"]) && isset($_POST["pseudoU"])) {
    // Si la saisie a été effectuée
    if ($_POST["mailU"] != "" && $_POST["mdpU"] != "" && $_POST["pseudoU"] != "") {

        //Si l'email n'existe pas deja dans la BDD
        if (UtilisateurDAO::checkEmail('mailU')){

        // Récupère tous les champs sont renseignés
        $mailU = $_POST["mailU"];
        $mdpU = $_POST["mdpU"];
        $pseudoU = $_POST["pseudoU"];

        // Enregistrement des donnees dans la base de données
        $user = new Utilisateur(0, $mailU, $mdpU, $pseudoU);
        
        // Insertion en 2 temps : 
        // 1- tout sauf le mot de passe
        $ret = UtilisateurDAO::insert($user);
        if ($ret) {
            $inscriptionReussie = true;
            $user=UtilisateurDAO::getOneByMail($_POST[$mailU]);
            UtilisateurDAO::updateMdp($user->getIdU(), $mdpU);
        } else {
            ajouterMessage("Inscription : l'utilisateur n'a pas pu être enregistré.");
        }
        } else {
            ajouterMessage("Inscription : Mail déjà utilisé");
        }
    } else {
        ajouterMessage("Inscription : renseigner tous les champs...");
    }
}

// Construction de la vue
if ($inscriptionReussie) {
    $titre = "Inscription confirmée";
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/vueConfirmationInscription.php";
    require_once "$racine/vue/pied.html.php";
} else {
    // Première demande ou bien erreurs dans le formulaire
    $titre = "Inscription pb";
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/vueInscription.php";
    require_once "$racine/vue/pied.html.php";
}
?>
