<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>AimerDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\AimerDAO;
        use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';

        try {
            Bdd::connecter();
            ?>
            <h2>Test AimerDAO</h2>

             <h3>1- estAimeByIdU</h3>
            <?php $unIdR = 1 ; $unIdU = 3; ?>
            <p>L'utilisateur d'id <?= $unIdU ?> aime le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
             var_dump(AimerDAO::estAimeById($unIdU, $unIdR));
            ?>
            <?php $unIdR = 1 ; $unIdU = 6; ?>
            <p>L'utilisateur d'id <?= $unIdU ?> aime le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
             var_dump(AimerDAO::estAimeById($unIdU, $unIdR));
             
             ?>
            <h3>2- insert</h3>
            <?php 
            $unIdR = 1 ; $unIdU = 6; 
            $ok = AimerDAO::insert($unIdU, $unIdR)
            ?>
            Réussite de l'ajout : 
            <?php var_dump($ok); ?>
            <p>Après ajout, L'utilisateur d'id <?= $unIdU ?> aime-t-il le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
             var_dump(AimerDAO::estAimeById($unIdU, $unIdR));

             ?>
            <h3>3- delete</h3>
            <?php 
            $unIdR = 1 ; $unIdU = 6; 
            $ok = AimerDAO::delete($unIdU, $unIdR)
            ?>
            Réussite de la suppression : 
            <?php var_dump($ok); ?>
            <p>Après suppression, L'utilisateur d'id <?= $unIdU ?> aime-t-il le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
             var_dump(AimerDAO::estAimeById($unIdU, $unIdR));

            Bdd::deconnecter();
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
        ?>

    </body>
</html>
