<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RestoDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\RestoDAO;
        use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';
        
        // Pour augmenter les limites de var_dump
        ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');


        try {
            Bdd::connecter();
            ?>
            <h2>Test RestoDAO</h2>

            <h3>1- getOneById</h3>
            <?php $idR = 6; ?>
            <p>Le restaurant n° <?= $idR ?></p>
            <?php
            $leResto = RestoDAO::getOneById($idR);
            var_dump($leResto);
            
            ?>
            <h3>2- getAll</h3>
            <p>Tous les restaurants</p>
            <?php
            $lesRestos = RestoDAO::getAll();
            var_dump($lesRestos);
                        
            ?>
            <h3>3- getTop4</h3>
            <p>Les quatre restaurants les mieux notés</p>
            <?php
            $lesRestos = RestoDAO::getTop4();
            var_dump($lesRestos);
            
            ?>
            
            ?>
            <h3>5- getAllByNom</h3>
            <p>Filtrage des restaurants sur le  nom</p>
            <?php
            $lesRestos = RestoDAO::getAllByNomR("pot");
            var_dump($lesRestos);
            
            ?>
            <h3>6- getAllByAdresse</h3>
            <p>Filtrage des restaurants sur l'adresse</p>
            <?php
            $lesRestos = RestoDAO::getAllByAdresse("du", "","Bay");
            var_dump($lesRestos);
            
            ?>
            <h3>7- getRestosByMultiCriteres</h3>
            <p>Filtrage des restaurants multicritères</p>
            <?php
            $lesRestos = RestoDAO::getAllMultiCriteres("pot", "du", "","Bay", array(3, 6));
            var_dump($lesRestos);
            
            ?>
            <h3>8- getAimesByIdU</h3>
            <?php $unIdU = 7;  ?>
            <p>Liste des restaurants aimés par l'utilisateur <?= $unIdU ?> (chargement de type "lazy")</p>
            <?php
            $lesRestos = RestoDAO::getAimesByIdU($unIdU);
            var_dump($lesRestos);
            
            ?>

            <?php            
            Bdd::deconnecter();
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
        ?>

    </body>
</html>
