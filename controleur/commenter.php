<?php

use modele\dao\Bdd;
use modele\dao\CritiqueDAO;
use modele\dao\UtilisateurDAO;
use modele\metier\Critique;

/**
 * Contrôleur commenter
 * Ajout/mise à jour du commentaire critique portée par l'utilisateur courant sur un restaurant
 * 
 * Vue contrôlée : aucune
 * Données GET : 
 *      - $idR identifiant du restaurant concerné
 *      - $commentaire commentaire apporté par l'utilisateur courant sur le restaurant
 * 
 * @version 07/2021 intégration couche modèle objet
 * @version 08/2021 gestion erreurs
 */
Bdd::connecter();


// Récupération des données GET, POST, et SESSION
if (!isset($_GET["idR"])) {
    // Pb : pas d'id de restaurant
    ajouterMessage("Commenter : il faut fournir un identifiant de restaurant");
    $titre = "erreur";
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/pied.html.php";
} else {
    $idR = intval($_GET["idR"]);
    $commentaire = $_POST["commentaire"];

// Un utilisateur doit être connecté
    $idU = getIdULoggedOn();
    if ($idU != 0) {
        $laCritique = CritiqueDAO::getOneById($idR, $idU);
// Si aucune critique n'a déjà été émise pour ce restaurant par l'utilisateur courant
        if (is_null($laCritique)) {
            // créer une nouvelle critique avec le commentaire pour ce restaurant, par cet utilisateur
            $user = UtilisateurDAO::getOneById($idU);
            $laCritique = new Critique(null, $commentaire, $user); // pas de note pour le moment
            CritiqueDAO::insert($idR, $laCritique);
        } else {
            // simplement mettre à jour le commentaire de la critique
            $laCritique->setCommentaire($commentaire);
            CritiqueDAO::update($idR, $laCritique);
        }
    }
// redirection vers la page appelante
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>