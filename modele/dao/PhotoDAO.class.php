<?php

namespace modele\dao;

use modele\metier\Photo;
use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of CrtiqueDao
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class PhotoDAO {

    /**
     * Retourne un objet Photo d'après son identifiant 
     * @param int $id identifiant de l'objet recherché
     * @return Photo
     * @throws Exception
     */
    public static function getOneById(int $id): Photo {
        $laPhoto = null;
        try {
            $requete = "SELECT * FROM photo WHERE idP = :id";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                $laPhoto = new Photo($enreg['idP'], $enreg['cheminP']);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneById : <br/>" . $e->getMessage());
        }
        return $laPhoto;
    }
    
    /**
     * Liste des photos pour un restaurant donné
     * @param int $idR
     * @return array
     * @throws Exception
     */
    public static function getAllByResto(int $idR): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM photo WHERE idR = :idR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lesObjets[] = new Photo($enreg['idP'], $enreg['cheminP']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByResto : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }
    

}
