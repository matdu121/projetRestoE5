<?php
use modele\metier\Critique;
use \modele\metier\Utilisateur;
require_once '../../includes/autoload.inc.php';

$user = new Utilisateur(6, 'test@bts.sio', 'seSzpoUAQgIl', 'testeur SIO');
$uneCritique = new Critique(5, "Parfait", $user);
?>
<h2>Test unitaire de la classe Critique</h2>
<?php
var_dump($uneCritique);

