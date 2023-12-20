<?php
use \modele\metier\Utilisateur;

require_once '../../includes/autoload.inc.php';

$user = new Utilisateur(6, 'test@bts.sio', 'seSzpoUAQgIl', 'testeur SIO');

?>
<h2>Test unitaire de la classe Utilisateur</h2>
<?php
var_dump($user);

