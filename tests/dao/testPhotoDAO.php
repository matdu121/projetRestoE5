<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>PhotoDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\PhotoDAO;
        use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';

        try {
            Bdd::connecter();
            ?>
            <h2>Test PhotoDAO</h2>

            <h3>1- getOneById</h3>
            <?php $id = 10; ?>
            <p>La photo n° <?=$id?></p>
            <?php
            $unePhoto = PhotoDAO::getOneById($id);
            var_dump($unePhoto);
                        
            ?>
            <h3>2- getAllByResto</h3>
            <?php $idR = 4; ?>
            <p>Les photos du restaurant n° <?=$idR?></p>
            <?php
            $lesPhotos = PhotoDAO::getAllByResto($idR);
            var_dump($lesPhotos);       

            Bdd::deconnecter();
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
        ?>

    </body>
</html>
