<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>UtilisateurDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\UtilisateurDAO;
        use modele\metier\Utilisateur;
        use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';
        
        // Pour augmenter les limites de var_dump
        ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');


        try {
            Bdd::connecter();
            ?>
            <h2>Test UtilisateurDAO</h2>

            <h3>1- getOneByMail</h3>
            <?php $unMail = "test@bts.sio"; ?>
            <p>L'utilisateur de mail <?= $unMail ?></p>
            <?php
            $unUser = UtilisateurDAO::getOneByMail($unMail);
            var_dump($unUser);
            
            ?>
            <h3>2- getOneById</h3>
            <?php $unIdU = 3; ?>
            <p>L'utilisateur d'id <?= $unIdU ?></p>
            <?php
            $unUser = UtilisateurDAO::getOneById($unIdU);
            var_dump($unUser);
            
            
            ?>            
            <h3>3- insert sans le mot de passe</h3>
            <?php $user = new Utilisateur(0, 'test@insert.nb', '1234', 'pseudo de test'); ?>
            <p>Ajouter un utilisateur  <?= $user->__toString() ?></p>
            <?php
            $ok = UtilisateurDAO::insert($user);
            var_dump($ok);
                        
            ?>            
            <h3>4- update sans le mot de passe</h3>
            <?php $userLuAvant = UtilisateurDAO::getOneByMail("test@insert.nb"); ?>
            <p>Mettre à jour un utilisateur </p>
            <p>Utilisateur lu avant la mise à jour :  <?= $userLuAvant->__toString() ?></p>             
            <?php
            $userModifie = $userLuAvant;
            $userModifie->setMailU("le-mien@contact.fr");
            $userModifie->setPseudoU("pseudomodifie44");
            $userModifie->setMdpU("sio");
            $ok = UtilisateurDAO::update($userModifie);
            ?>
            Mise à jour réussie ?<br/>
            <?php
            var_dump($ok);
            
            $userLuApres = UtilisateurDAO::getOneById($userLuAvant->getIdU());
            ?>
           <p>Utilisateur lu après la mise à jour :  <?= $userLuApres->__toString() ?></p>
            
            ?>            
            <h3>5- update du mot de passe</h3>
            <?php $userLuAvant = $userLuApres ?>
            <p>Mettre à jour le mot de passe d'un utilisateur </p>
            <p>Utilisateur lu avant la mise à jour :  <?= $userLuAvant->__toString() ?></p>             
            <?php
            $mdp = "sio";
            $ok = UtilisateurDAO::updateMdp($userModifie->getIdU(), $mdp);
            ?>
            Mise à jour réussie ?<br/>
            <?php
            var_dump($ok);
            $userLuApres = UtilisateurDAO::getOneById($userModifie->getIdU());
            ?>
           <p>Utilisateur lu après la mise à jour :  <?= $userLuApres->__toString() ?></p>
          
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
