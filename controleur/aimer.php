<?php

use modele\dao\Bdd;
use modele\dao\AimerDAO;

/**
 * Contrôleur aimer
 * Ajout/suppression dans la liste des restaurants aimés par un utilisateur
 * 
 * Vue contrôlée : aucune
 * Données GET : $idR identifiant du restaurant concerné
 * 
 * @version 07/2021 intégration couche modèle objet
 * @version 08/2021 gestion erreurs
 */
Bdd::connecter();


// Récupération des données GET, POST, et SESSION
if (!isset($_GET["idR"])) {
    // Pb : pas d'id de restaurant
    ajouterMessage("Aimer : il faut fournir un identifiant de restaurant");
    $titre = "erreur";
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/pied.html.php";
} else {
    $idR = intval($_GET["idR"]);

// Récupération des données à tester
// Utilisateur couramment connecté
    $idU = getIdULoggedOn();
    if ($idU != 0) {
        $aimer = AimerDAO::estAimeById($idU, $idR);

// Bascule : 
//    si le restaurant était "aimé", il ne l'est plus
        if ($aimer) {
            AimerDAO::delete($idU, $idR);
        } else {
            //    sinon, il le devient
            AimerDAO::insert($idU, $idR);
        }
    }

// redirection vers la page appelante
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>