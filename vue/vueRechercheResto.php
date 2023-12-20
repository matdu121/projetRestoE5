<?php
/**
 * --------------
 * vueRechercheResto
 * --------------
 * 
 * @version 07/2021 par NB : intégration couche modèle objet
 * 
 * Variables transmises par le contrôleur rechercheResto contenant les données à afficher : 
  ----------------------------------------------------------------------------------------  */
/** @var string $critere (nom, adresse, type, multi) = critere de filtrage */
/** @var string $nomR nom du restaurant recherché */
/** @var string $villeR nom du restaurant recherché */
/** @var string $cpR nom du restaurant recherché */
/** @var string $voieAdrR nom du restaurant recherché */

?>

<h1>Recherche d'un restaurant</h1>
<form action="./?action=recherche&critere=<?= $critere ?>" method="POST">


    <?php
    switch ($critere) {
        case "nom":
            ?>
            Recherche par nom : <br />
            <input type="text" name="nomR" placeholder="nom *Laissez vide pour afficher tout les restaurants" value="<?= $nomR ?>" /><br />
            <?php
            break;
        case "adresse":
            ?>
            Recherche par adresse : <br />
            <input type="text" name="villeR" placeholder="ville" value="<?= $villeR ?>"/><br />
            <input type="text" name="cpR" placeholder="code postal" value="<?= $cpR ?>"/>*5 Caractères requis<br />
            <input type="text" name="voieAdrR" placeholder="rue" value="<?= $voieAdrR ?>"/><br />
            <?php
            break;
            case "type":
                ?> 
                <fieldset>
                    <legend>Recherche par type de cuisine</legend>
                    <input type="checkbox" name="options[]" value="1" />Sud ouest<br/>
                    <input type="checkbox" name="options[]" value="2" />Japonaise<br />
                    <input type="checkbox" name="options[]" value="3" />Orientale<br />
                    <input type="checkbox" name="options[]" value="4" />Fast food<br />
                    <input type="checkbox" name="options[]" value="5" />Vegetarien<br />
                    <input type="checkbox" name="options[]" value="6" />Vegan<br />
                    <input type="checkbox" name="options[]" value="7" />Crêpes<br />
                    <input type="checkbox" name="options[]" value="8" />Sandwich<br />
                    <input type="checkbox" name="options[]" value="9" />Tartes<br />
                    <input type="checkbox" name="options[]" value="10" />Viandes<br />
                    <input type="checkbox" name="options[]"  value="11"/>Grillade<br />
                </fieldset>
                <?php
                break;
        case "multi":
            ?>
            Recherche multi-critères<br />
            <input type="text" name="nomR" placeholder="nom du restaurant" value="<?= $nomR ?>"/>
            <input type="text" name="voieAdrR" placeholder="rue" value="<?= $voieAdrR ?>"/><br />
            <input type="text" name="cpR" placeholder="code postal" value="<?= $cpR ?>"/>
            <input type="text" name="villeR" placeholder="ville" value="<?= $villeR ?>"/>
            <br />
             <?php
            break;
    }
    ?>  
      
    
    <br /><br />
    <input type="submit" value="Rechercher" />

</form>