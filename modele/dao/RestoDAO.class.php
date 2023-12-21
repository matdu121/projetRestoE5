<?php

namespace modele\dao;

use modele\metier\Resto;
use modele\dao\CritiqueDAO;
use modele\dao\PhotoDAO;
use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of RestoDAO
 * N.B. : chargement de type "lazy" pour casser le cycle suivant :
 * "un restaurant collectionne des critiques, une critique est émise par un utilisateur, un utilisateur aime des restaurants"
 * Donc, pour chaque critique,  on charge l'objet Utilisateur qui a émis la critique, mais sans ses restaurants aimés 
 * @author N. Bourgeois
 * @version 07/2021
 */
class RestoDAO {

    /**
     * Retourne un objet Resto d'après son identifiant
     * @param int $id identifiant de l'objet Resto recherché
     * @return Resto l'objet Resto recherché ou null
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getOneById(int $id): ?Resto {
        $leResto = null;
        try {
            $requete = "SELECT * FROM resto WHERE idR = :idR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $id, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                // Extraire l'enregistrement obtenu
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                //Instancier un nouveau restaurant
                $leResto = self::enregistrementVersObjet($enreg);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneById : <br/>" . $e->getMessage());
        }
        return $leResto;
    }

    /**
     * Retourne tous les restaurants
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAll(): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAll : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste  des 4 restaurants les mieux notés par les critiques
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getTop4(): array {
        $lesObjets = array();
        try {            
            $requete = "SELECT AVG(note) AS NotesCumulees, r.idR, nomR, numAdrR, voieAdrR, cpR, villeR, latitudeDegR, longitudeDegR, descR, horairesR  
                       FROM resto r
                       INNER JOIN critiquer c ON r.idR = c.idR 
                       GROUP BY r.idR, nomR, numAdrR, voieAdrR, cpR, villeR, latitudeDegR, longitudeDegR, descR, horairesR 
                       ORDER BY NotesCumulees DESC 
                       LIMIT 4;
                    ";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getTop4 : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    

    /**
     * Liste des restaurants filtrée sur le nom ou un extrait du nom.
     * Filtrage : les restaurants sélectionnés contiennent la sous-chaîne passée en paramètre dans leur nom
     * @param string $extraitNomR chai,ne à rechercher dasn les noms des restaurants
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllByNomR(string $extraitNomR): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto WHERE nomR LIKE :nomR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $motif = "%" . $extraitNomR . "%";
            $stmt->bindParam(':nomR', $motif, PDO::PARAM_STR);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByNom : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }


    /**
     * Iteration 4
     * Fonction getAllByTypeR($typeR): array
     * Cette fonction statique récupère une liste d'objets restaurant en fonction de(s) type(s) de cuisine demandé(s) par l'user.

     * Paramètres
     * $typeR (array): Un tableau contenant les identifiants des types de cuisine pour lesquels vous souhaitez récupérer les restaurants.
     
     * Retour
     * array: Un tableau d'objets restaurant correspondant aux critères de recherche.

     * Fonctionnalité
     * Construction de la requête SQL :
     * La fonction crée une requête SQL pour récupérer des données de la table resto en joignant la table typecuisine_resto via l'identifiant du restaurant (idR).
     * Elle utilise les identifiants de types de cuisine spécifiés pour filtrer les résultats.
     * 
     * Création des conditions de filtrage :
     * Pour chaque identifiant de type de cuisine dans $typeR, la fonction crée des conditions de filtrage SQL pour les correspondances d'idTC dans la jointure.
     * Ces conditions sont combinées avec un OR dans la requête finale.
     * 
     * Exécution de la requête et récupération des résultats :
     * La requête SQL est préparée et exécutée à l'aide de PDO (PHP Data Objects).
     * Les résultats sont parcourus et convertis en objets restaurant à l'aide de la méthode enregistrementVersObjet() définie plus bas dans ce fichier.
     */

     public static function getAllByTypeR($typeR): array {
                                                                          
        if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] === 'http://localhost/html/Annee3/projetRestoE5/?action=accueil' || $_SERVER['HTTP_REFERER'] === '10.15.253.250/mgarnier/projetRestoE5/?action=accueil')) {
            // Le visiteur vient de la page d'accueil du site
            $lesObjets = array();
            $typeAcc = isset($_POST['typeR']) ? $_POST['typeR'] : null;
            $typeAccString = implode($typeAcc);
            try {
                $requete = "SELECT * FROM resto INNER JOIN typecuisine_resto ON typecuisine_resto.idR = resto.idR";
                $conditions = " WHERE typecuisine_resto.idTC = '" . $typeAccString . "'";
                $requete .= $conditions . ";";
                
                //echo($requete);
                $stmt = Bdd::getConnexion()->prepare($requete);
                $ok = $stmt->execute();
                // attention, $ok = true pour un select ne retournant aucune ligne
                if ($ok) {
                    // Pour chaque enregistrement
                    while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        //Instancier un nouveau restaurant et l'ajouter à la liste
                        $lesObjets[] = self::enregistrementVersObjet($enreg);
                    }
                }
            } catch (PDOException $e) {
                throw new Exception("Depuis accueil : Erreur dans la méthode " . get_called_class() . "::getAllByTypeR : <br/>" . $e->getMessage());
            }
            return $lesObjets;
        } else {
            // Le visiteur ne vient pas de la page d'accueil. Traitement normal
            $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto INNER JOIN typecuisine_resto ON typecuisine_resto.idR = resto.idR";
            $conditions = [];

            foreach ($typeR as $unType) {
                $conditions[] = "typecuisine_resto.idTC = '" . $unType . "'";
            }

            if (!empty($conditions)) {
                $requete .= " WHERE " . implode(" OR ", $conditions) . ";";
            } else {
                $requete .= ";";
            }
            //echo($requete);
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Depuis recherche : Erreur dans la méthode " . get_called_class() . "::getAllByTypeR : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }
}

    /**
     * Liste des restaurants filtrée sur les éléments de l'adresse.
     * @param string $voieAdrR voie ex : "rue de Crébillon"
     * @param string $cpR code postal ex : "44000"
     * @param string $villeR ex : "NANTES"
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllByAdresse(string $voieAdrR, string $cpR, string $villeR): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto WHERE voieAdrR LIKE :voieAdrR AND cpR LIKE :cpR AND villeR LIKE :villeR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $motifVoieAdrR = "%" . $voieAdrR . "%";
            $motifCpR = "%" . $cpR . "%";
            $motifVilleR = "%" . $villeR . "%";
            $stmt->bindParam(':voieAdrR', $motifVoieAdrR, PDO::PARAM_STR);
            $stmt->bindParam(':cpR', $motifCpR, PDO::PARAM_STR);
            $stmt->bindParam(':villeR', $motifVilleR, PDO::PARAM_STR);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByAdresse : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Recherche de restaurants selon plusieurs critères (filtrage)
     * Tous les critères doivent être réunis (ET logique) sauf les types de cuisine, 1 au moins parmi tous (OU logique)
     * Les valeurs des critères de type string peuvent-être incomplètes (on cherche une sous-chaîne)
     * @param string $nomR nom du restaurant
     * @param string $voieAdrR nom de la rue
     * @param string $cpR code postal
     * @param string $villeR ville du restaurant
     * @return array  tableau d'objets Resto
     * @throws Exception Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllMultiCriteres(string $extraitNomR, string $voieAdrR, string $cpR, string $villeR): array {
        $lesObjets = array();
        try {
            
                $requete = "SELECT DISTINCT r.* "
                        . " FROM resto r "
                        . " WHERE nomR LIKE :nomR"
                        . " AND  voieAdrR LIKE :voieAdrR AND cpR LIKE :cpR AND villeR LIKE :villeR"
                        . " ORDER BY nomR";
                $stmt = Bdd::getConnexion()->prepare($requete);
                $motifNom = "%" . $extraitNomR . "%";
                $motifVoieAdrR = "%" . $voieAdrR . "%";
                $motifCpR = "%" . $cpR . "%";
                $motifVilleR = "%" . $villeR . "%";
                $stmt->bindParam(':nomR', $motifNom, PDO::PARAM_STR);
                $stmt->bindParam(':voieAdrR', $motifVoieAdrR, PDO::PARAM_STR);
                $stmt->bindParam(':cpR', $motifCpR, PDO::PARAM_STR);
                $stmt->bindParam(':villeR', $motifVilleR, PDO::PARAM_STR);
                $ok = $stmt->execute();
                // attention, $ok = true pour un select ne retournant aucune ligne
                if ($ok) {
                    // Pour chaque enregistrement
                    while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        //Instancier un nouveau restaurant et l'ajouter à la liste
                        $lesObjets[] = self::enregistrementVersObjet($enreg);
                    }
                }
            
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllMultiCriteres : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des restaurants aimés par un utilisateurdonné
     * N.B. : chargement de type "lazy"  : pour chaque restaurant, on ne chargera pas les critiques, les photos 
     * @param int $idU id d'un utilisateur
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAimesByIdU(int $idU): array {
        $lesObjets = array();
        try {
            $requete = "SELECT resto.* FROM resto "
                    . " INNER JOIN aimer ON resto.idR = aimer.idR"
                    . " WHERE idU = :idU";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = new Resto
                            (
                            $enreg['idR'], $enreg['nomR'], $enreg['numAdrR'], $enreg['voieAdrR'], $enreg['cpR'], $enreg['villeR'],
                            $enreg['latitudeDegR'], $enreg['longitudeDegR'], $enreg['descR'], $enreg['horairesR']
                    );
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAimesByIdU : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }



    /**
     * Fabrique un objet restaurant à partir d'un enregistrement de la table resto
     * N.B. : chargement de type "lazy" pour casser le cycle suivant :
     * "un restaurant collectionne des critiques, une critique est émise par un utilisateur, un utilisateur aime des restaurants"
     * Donc, pour chaque critique,  on charge l'objet Utilisateur qui a émis la critique, mais sans ses restaurants aimés 
     * @param array $enreg
     * @return Resto
     */
    private static function enregistrementVersObjet(array $enreg): Resto {
        $id = $enreg['idR'];
        // Instanciation sans les associations
        $leResto = new Resto(
                $enreg['idR'], $enreg['nomR'], $enreg['numAdrR'], $enreg['voieAdrR'], $enreg['cpR'], $enreg['villeR'],
                $enreg['latitudeDegR'], $enreg['longitudeDegR'], $enreg['descR'], $enreg['horairesR']
        );
        // Objets associés   
        $lesCritiques = CritiqueDAO::getAllByResto($id);
        $lesPhotos = PhotoDAO::getAllByResto($id);
        
        
        $leResto->setLesPhotos($lesPhotos);
        $leResto->setLesCritiques($lesCritiques);

        return $leResto;
    }
   
}
