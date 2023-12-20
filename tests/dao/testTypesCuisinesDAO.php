<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TypesCuisinesDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\TypesCuisinesDAO;
         use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';
        
        // Pour augmenter les limites de var_dump
        ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');


        try {
            Bdd::connecter();
            ?>
            <h2>Test TypesCuisinesDAO</h2>

            <h3>1- getAllByResto</h3>
            <?php $idR = 2; ?>
            <p>Le restaurant n° <?= $idR ?></p>
            <?php
            $leResto = TypesCuisinesDAO::getAllByResto($idR);
            var_dump($leResto);
            ?>
            
            <?php
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
        ?>

    </body>
</html>
