<?php
use modele\metier\Photo;
require_once '../../includes/autoload.inc.php'; 
$unePhoto = new Photo(6, "cidrerieDuFronton.jpg");
?>
<h2>Test unitaire de la classe Photo</h2>
<?php

var_dump($unePhoto);


