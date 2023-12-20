<?php

namespace modele\dao;

use modele\metier\Critique;
use modele\metier\Utilisateur;
use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of CritiqueDao
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class CritiqueDAO {

    /**
     * Note moyenne de toutes les critiques pour un restaurant donné
     * @param int $idR identifiant du restaurant
     * @return float note moyenne ou -1 si aucune critique
     * @throws Exception Transmission des erreurs PDO éventuelles
     */
    public static function getNoteMoyenneByIdR(int $idR): float {
        $retour = -1;
        try {
            $requete = "select avg(note) as moyenne from critiquer where idR=:idR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok && $stmt->rowCount() > 0) {
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                // Même si la valeur de $idR n'apparaît dans aucun enregistrement, la requête retourne NULL dans le champ 'moyenne' !
                if (!is_null($enreg["moyenne"])){
                    $retour = $enreg["moyenne"];
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getNoteMoyenneByIdR : <br/>" . $e->getMessage());
        }
        return $retour;
    }

    /**
     * Retourne un objet Critique d'après son identifiant (idR + idU)
     * N.B. : chargement de type "lazy" pour casser le cycle 
     * "une critique est émise par un utilisateur, un utilisateur aime des restaurants, un restaurant collectionne des critiques"
     * Donc on charge l'objet Utilisateur qui a émis la critique, mais sans ses restaurants aimés ni ses types de cuisine préférés
     * @param int $idR identifiant du restaurant critiqué
     * @param int $idU identifiant de l'utilisateur qui a émis la critique
     * @return Critique l'objet Critique recherché ou null 
     * @throws Exception Transmission des erreurs PDO éventuelles
     */
    public static function getOneById(int $idR, int $idU): ?Critique {
        $laCritique = null;
        try {
            $requete = "SELECT * FROM critiquer c"
                    . " INNER JOIN utilisateur u ON  c.idU = u.idU "
                    . " WHERE idR = :idR AND c.idU = :idU";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                $user = new Utilisateur($enreg['idU'], $enreg['mailU'], $enreg['mdpU'], $enreg['pseudoU']);
                $laCritique = new Critique($enreg['note'], $enreg['commentaire'], $user);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneById : <br/>" . $e->getMessage());
        }
        return $laCritique;
    }

    /**
     * Liste des critiques pour un restaurant donné
     * N.B. : chargement de type "lazy" pour casser le cycle 
     * "une critique est émise par un utilisateur, un utilisateur aime des restaurants, un restaurant collectionne des critiques"
     * Donc on charge l'objet Utilisateur qui a émis la critique, mais sans ses restaurants aimés ni ses types de cuisine préférés
     * @param int $idR
     * @return array
     * @throws Exception
     */
    public static function getAllByResto(int $idR): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM critiquer c"
                    . " INNER JOIN utilisateur u ON  c.idU = u.idU "
                    . " WHERE idR = :idR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $user = new Utilisateur($enreg['idU'], $enreg['mailU'], $enreg['mdpU'], $enreg['pseudoU']);
                    $lesObjets[] = new Critique($enreg['note'], $enreg['commentaire'], $user);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByResto : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Ajouter une critique à la table critiquer
     * Une critique concerne à un restaurant
     * @param int $idR identifiant du restaurant concerné
     * @param Critique $uneCritique critique d'un utilisateur
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function insert(int $idR, Critique $uneCritique): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("INSERT INTO critiquer (idU, idR, note, commentaire) VALUES(:idU,:idR, :note, :commentaire)");
            $stmt->bindValue(':idU', $uneCritique->getLeUtilisateur()->getIdU(), PDO::PARAM_INT);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindValue(':note', $uneCritique->getNote(), PDO::PARAM_INT);   
            $stmt->bindValue(':commentaire', $uneCritique->getCommentaire(), PDO::PARAM_STR);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insert : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

    /**
     * Suppimer un couple (idU, idR) de la table critiquer
     * @param int $idU identifiant de l'utilisateur
     * @param int $idR identifiant du restaurant
     * @return bool true si réussite, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function delete(int $idR, int $idU): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("DELETE FROM critiquer WHERE idR=:idR and idU=:idU");
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::delete : <br/>" . $e->getMessage());
        }
        return $resultat;
    }
    
    
    public static function update(int $idR, Critique $uneCritique): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("UPDATE critiquer SET note = :note, commentaire = :commentaire WHERE idU = :idU AND idR = :idR");
            $stmt->bindValue(':idU', $uneCritique->getLeUtilisateur()->getIdU(), PDO::PARAM_INT);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindValue(':note', $uneCritique->getNote(), PDO::PARAM_INT);   
            $stmt->bindValue(':commentaire', $uneCritique->getCommentaire(), PDO::PARAM_STR);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::update : <br/>" . $e->getMessage());
        }
        return $resultat;
    }
    
}
