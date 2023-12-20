<?php
/**
 * --------------
 * entete
 * --------------
 * @version 08/2021 Gestion des messages d'erreur
 * 
 * 
 * Variables transmises par le contrôleur contenant les données à afficher :  
  ---------------------------------------------------------------------------------- */
/** @var array $GLOBALS['lesMessages'] liste des messages (d'erreurs) à afficher */
/** @var string $GLOBALS['isLoggedOn'] témoin de la réalité de la connexion d'un utilisateur */
/** @var string $titre */
/** @var array  $menuBurger */

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?= $titre ?></title>
        <!--
        <style type="text/css">
            @import url("css/base.css");
            @import url("css/form.css");
            @import url("css/cgu.css");
            @import url("css/corps.css");
        </style>
        -->
        <link href="css/base.css" rel="stylesheet" type="text/css">
        <link href="css/form.css" rel="stylesheet" type="text/css">
        <link href="css/cgu.css" rel="stylesheet" type="text/css">
        <link href="css/corps.css" rel="stylesheet" type="text/css">
        
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    </head>
    <body>
        <nav> 

            <ul id="menuGeneral">
                <li><a href="./?action=accueil">Accueil</a></li> 
                <li><a href="./?action=recherche"><img src="images/rechercher.png" alt="loupe" />Recherche</a></li>
                <li></li> 

                <li id="logo"><a href="./?action=accueil"><img src="images/logoBarre.png" alt="logo" /></a></li>
                <li></li> 
                <li><a href="./?action=cgu">CGU</a></li>
                <?php 
                    if ($GLOBALS['isLoggedOn']) { 
                 ?>
                    <li><a href="./?action=profil"><img src="images/profil.png" alt="loupe" />Mon Profil</a></li>
                <?php }
                 
                ?>              
            </ul>
        </nav>
        <div id="bouton">
            <div></div>
            <div></div>
            <div></div>
        </div>


        <ul id="menuContextuel">
            <li><img src="images/logoBarre.png" alt="logo" /></li>
            <?php if (isset($menuBurger)) { ?>
                <?php for ($i = 0; $i < count($menuBurger); $i++) { ?>
                    <li>
                        <a href="<?php echo $menuBurger[$i]['url']; ?>">
                            <?php echo $menuBurger[$i]['label']; ?>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>

        <div id="corps">
            <?php
            // Gestion des erreurs
            // Si il y a des messages à afficher
            if (count($GLOBALS['lesMessages']) != 0) {
                ?>

                <h1 class="erreur" >Liste des erreurs</h1>
                <ul>
                    <?php
                    // Parcourir la liste des messages pour les afficher
                    foreach ($GLOBALS['lesMessages'] as $unMessage) {
                        ?>
                        <li> <?= $unMessage ?> </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>

