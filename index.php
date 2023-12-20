<?php
/**
 * Contrôleur frontal
 *   - décode l'action fournie en paramètre GET et inclut le contrôleur correspondant
 *   - initialise la variable $GLOBALS['isLoggedOn'] : vérifie qu'un utilisateur est connecté ou non (pour l'affichage du menu par entete.html.php)
 *   - initialise la variable $GLOBALS['lesMessages'][] : tableua des messages d'erreur à afficher (par entete.html.php)
 * On utilise le tableau $GLOBALS qui évite d'avoir à redéclarer les variables comme globales (mot-clef "global") pour pouvoir les utiliser dans des fonctions

 * @version 08/2021 Gestion des exceptions
 */
require_once "getRacine.php";
require_once "$racine/includes/gestionErreurs.inc.php";         // fonctions de gestion des messages d'erreurs
require_once "$racine/includes/autoload.inc.php";               // fonction de chargement automatique des classes (couche modele)
require_once "$racine/includes/controleurPrincipal.inc.php";    // fonction de correspondance action/contrôleur
require_once "$racine/includes/authentification.inc.php";       // gestion des sessions authentifiées


// Initialisation des variables globales
$GLOBALS['lesMessages'] = array();  // liste des messages (d'erreurs) à afficher
$GLOBALS['isLoggedOn'] = false;     // témoin de la réalité de la connexion d'un utilisateur

// Décodage du paramètre action et détermination du contrôleur correspondant
if (isset($_GET["action"])){
    $action = $_GET["action"];
}
else{    
    $action = "defaut";
}
$fichier = controleurPrincipal($action);


// Appel du contrôleur
//try{
    $GLOBALS['isLoggedOn'] = isLoggedOn();  // vérifier si un utilisateur est connecté de façon licite
    require_once "$racine/controleur/$fichier";
//} catch (Throwable $e) {    // Throwable : inclus les exceptions de type Exception et de type Error
//    // Si une exception est levée, on la traite en affichant un message, sans interrompre l'application
//    ajouterMessage($action." : ".$e->getMessage());
//    // Pour afficher le message d'erreur relatif à l'exception, on se contente de l'entête et du pied de page
//    $titre = "Erreur";
//    require_once "$racine/vue/entete.html.php";
//    require_once "$racine/vue/pied.html.php";
//}

//// POUR DEBOGUER
//    $GLOBALS['isLoggedOn'] = isLoggedOn();  // vérifier si un utilisateur est connecté de façon licite
//    require_once "$racine/controleur/$fichier";
    


     