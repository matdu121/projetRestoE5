<?php
/**
 * --------------
 * vueMonProfil
 * --------------
 * 
 * @version 07/2021 par NB : intégration couche modèle objet
 * 
 * Variables transmises par le contrôleur detailResto contenant les données à afficher : 
  ---------------------------------------------------------------------------------------- */
/** @var Utilisateur  $util utilisteur à afficher */

/** @var array $mesRestosAimes  */
/** @var int $idU  */
/** @var string $mailU  */
/**
 * Variables supplémentaires :  
  ------------------------- */
/** @var Resto $unResto */

?>

<h1>Mon profil</h1>

Mon adresse électronique : <?= $util->getMailU() ?> <br />
Mon pseudo : <?= $util->getPseudoU() ?> <br />

<hr>

les restaurants que j'aime : <br />
<?php
foreach ($mesRestosAimes as $unResto) {
    ?>
    <a href="./?action=detail&idR=<?= $unResto->getIdR() ?>"><?= $unResto->getNomR() ?></a><br />
    <?php
}
?>

<hr>
<a href="./?action=deconnexion">se deconnecter</a>


