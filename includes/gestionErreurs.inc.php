<?php

/** ******************************************************************
 * Fonctions de gestion des messages d'erreurs
 * Principe : 
 *      - un tableau global contient la liste des messages correspondant 
 * aux erreurs rencontrées par le controleur
 *      - s'il y a au moins une erreur, la liste des messages est affichée
 * sur la vue
 *      - deux types d'erreurs :
 *          - une exception levée : récupérée par le contrôleur
 *          - une erreur détectée par programme
 * 
 * @version 08/2021 
 * 
 * ******************************************************************* */

    /**
     * Ajout d'un message d'erreurs
     * @param string $msg message d'erreur à ajouter
     */
    function ajouterMessage(string $msg) {
        // si la liste des erreurs n'existe pas : la créer
        if (!isset($GLOBALS['lesMessages'])) {
            $GLOBALS['lesMessages'] = array();
        }
        // ajouter le message passé en paramètre à la liste des erreurs
        $GLOBALS['lesMessages'][] = htmlentities($msg, ENT_QUOTES, 'UTF-8');
    }

