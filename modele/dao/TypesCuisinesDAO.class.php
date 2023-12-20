<?php

namespace modele\dao;
use modele\dao\Bdd;
use modele\metier\TypesCuisine;
use PDO;
use PDOException;
use Exception;

class TypesCuisinesDAO {
    
    /* Fonction getAllByResto(string $idR): array
    Récupère tous les types de cuisine associés à un restaurant spécifique.

    Paramètres :
    $idR : Chaîne de caractères représentant l'identifiant du restaurant.
    Retour :
    Un tableau d'objets TypesCuisine. */
    public static function getAllByResto(string $idR): array {
        $lesTypes = array();
        
        try {
            $requete = "SELECT * FROM typescuisine t INNER JOIN typecuisine_resto tcr ON t.idTC = tcr.idTC WHERE idR = :idR;";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_STR);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesTypes[] = new TypesCuisine($enreg['idTC'], $enreg['libelleTC']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByNom : <br/>" . $e->getMessage());
        }
        return $lesTypes; 
    }

    /* Fonction getAllByRestoAsString(string $idR): string
    Récupère les libellés des types de cuisine associés à un restaurant spécifique sous forme d'une chaîne de caractères.

    Paramètres :
    $idR : Chaîne de caractères représentant l'identifiant du restaurant.
    Retour :
    Une chaîne de caractères contenant les libellés des types de cuisine séparés par des virgules. */

    public static function getAllByRestoAsString(string $idR): string {
        $typesString = ""; // Chaîne vide pour stocker les libellés des types de cuisine
        
        try {
            $requete = "SELECT * FROM typescuisine t INNER JOIN typecuisine_resto tcr ON t.idTC = tcr.idTC WHERE idR = :idR;";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_STR);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Concaténer les libellés des types de cuisine avec une virgule comme séparateur
                    $typesString .= $enreg['libelleTC'] . ", ";
                }
                // Supprimer la dernière virgule et l'espace en trop à la fin
                $typesString = rtrim($typesString, ", ");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByNom : <br/>" . $e->getMessage());
        }
        
        return $typesString;
    }
    

    /* Fonction getAimesByIdU(int $idU): array
    Récupère les types de cuisine aimés par un utilisateur spécifique.

    Paramètres :
    $idU : Entier représentant l'identifiant de l'utilisateur.
    Retour :
    Un tableau d'objets TypesCuisine représentant les types de cuisine aimés par l'utilisateur.  */
    public static function getAimesByIdU(int $idU): array {
        $lesObjets = array();
        try {
            $requete = "SELECT typescuisine.* FROM typescuisine "
                    . " INNER JOIN cuisinepref ON typescuisine.idTC = cuisinepref.idTC"
                    . " WHERE idU = :idU";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = new TypesCuisine($enreg['idTC'],$enreg['libelleTC']); // mettre tout les types cuisines qu'ils aiment dans une liste d'objet typecuisine
                            
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAimesByIdU : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }
}

    
