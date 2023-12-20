<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CritiqueDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\CritiqueDAO;
        use modele\metier\Critique;
        use modele\dao\UtilisateurDAO;
        use modele\dao\Bdd;

require_once '../../includes/autoload.inc.php';

        try {
            Bdd::connecter();
            ?>
            <h2>Test CritiqueDAO</h2>

            <h3>1- getNoteMoyenneByIdR</h3>
            <?php $id = 1; ?>
            <p>La note moyenne des critiques du restaurant n° <?= $id ?></p>
            <?php
            $noteMoyenne = CritiqueDAO::getNoteMoyenneByIdR($id);
            var_dump($noteMoyenne);
            ?>
            <?php $id = 7; ?>
            <p>La note moyenne des critiques du restaurant n° <?= $id ?></p>
            <?php
            $noteMoyenne = CritiqueDAO::getNoteMoyenneByIdR($id);
            var_dump($noteMoyenne);
            ?>
            
            <h3>2- getOneById</h3>
            <?php $idR = 6;
            $idU = 5;
            ?>
            <p>La critique de l'utilisateur n° <?= $idU ?> pour le restaurant n° <?= $idR ?></p>
            <?php
            $laCritique = CritiqueDAO::getOneById($idR, $idU);
            var_dump($laCritique);
            ?>
            
            <h3>3- getAllByResto</h3>
            <?php $idR = 2; ?>
            <p>Les critiques pour le restaurant n° <?= $idR ?></p>
            <?php
            $desCritiques = CritiqueDAO::getAllByResto($idR);
            var_dump($desCritiques);
            ?>
            
            <h3>4- insert</h3>
            <?php
            $unIdR = 1;
            $unIdU = 1;
            $user = UtilisateurDAO::getOneById($unIdU);
            $laCritique = new Critique(4, "Supercalifragilistic", $user);
            $ok = CritiqueDAO::insert($unIdR, $laCritique);
            ?>
            Réussite de l'ajout : 
            <?php var_dump($ok); ?>
            <p>Après ajout, voici la nouvelle critique pour le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
            var_dump(CritiqueDAO::getOneById($unIdR, $user->getIdU()));
            ?>
            
            <h3>5- update</h3>
            <?php
            // On modifie la critique
            $laCritique->setNote(3);
            $laCritique->setCommentaire("expidelilicious");
            $ok = CritiqueDAO::update($unIdR, $laCritique);
            ?>
            Réussite de la modification : 
            <?php var_dump($ok); ?>
            <p>Après modification, voici la critique pour le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
            var_dump(CritiqueDAO::getOneById($unIdR, $user->getIdU()));
            ?>
            
            <h3>6- delete</h3>
            <?php
            $unIdR = 1;
            $unIdU = 1;
            $ok = CritiqueDAO::delete($unIdR, $unIdU);
            ?>
            Réussite de la suppression : 
            <?php var_dump($ok); ?>
            <p>Après suppression, la critique subsiste-t-elle pour le restaurant d'id <?= $unIdR ?> ? </p>
            <?php
            var_dump(CritiqueDAO::getOneById($unIdR, $unIdU));

            Bdd::deconnecter();
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
        ?>

    </body>
</html>
