<?php
namespace modele\dao;
use \PDO;
//use \PDOException;

/**
 * Description of Bdd
 * Classe de type "Singleton" de connexion à la base de données
 * @author N. Bourgeois
 * @version 2021 
 */


class Bdd {

    /**
     * @var PDO Objet de type PDO, dépositaire de la connexion courante à la BDD
     */
    private static ?PDO $pdo=null;
    private static $login = "resto_util";   // login utilisateur de la BDD
    private static $mdp = "secret";         // mdp  utilisateur de la BDD
    private static $bd = "resto2";          // nom de la BDD
    private static $serveur = "localhost";  // nom de domaine du serveur de BDD
    private static $pdoOptions = array  (
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"   // pour récupérer les données en UTF8
        ,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION        // permet la gestion des exceptions
        //,PDO::ATTR_CASE => PDO::CASE_UPPER                   // pour compatibilité avec Oracle database (noms de champs trancrits en majuscules)
                                        );

    /**
     * Crée un objet de type PDO et ouvre la connexion 
     * @return \PDO un objet de type PDO pour accéder à la base de données
     * @throws PDOException
     */
    public static function connecter() : ?PDO  {
        // on ne crée une connexion que si elle n'existe pas déjà ...
        if (is_null(self::$pdo)) {
                // instanciation d'un objet de connexion PDO
                self::$pdo = new PDO("mysql:host=".self::$serveur.";dbname=".self::$bd, self::$login, self::$mdp, self::$pdoOptions);                
        }
        return self::$pdo;
    }

    public static function deconnecter() : void {
        self::$pdo = null;
    }

    /**
     * Accesseur
     * @return PDO objet d'accès à la BDD ou bien null
     */
    public static function getConnexion() : ?PDO {
        return self::$pdo;
    }
    
    public static function estConnecte() : bool {
        return !is_null(self::$pdo);
    }

}
