# PHP Projet Site Resto

# Fonctionnalités qui marchent relativement.

-----
La recherche par type, par nom et par adresse et la multi critères malgré ces problèmes :
- La recherche par type ne renvoit pas de message indiquant qu'il n'y a aucun resultat dans le cas où cela arrive
- La recherche par nom ne renvoit pas de message indiquant qu'il n'y a aucun resultat dans le cas où cela arrive.
- La recherche par adresse ne renvoit pas de message indiquant qu'il n'y a aucun resultat dans le cas où cela arrive,
  de plus, si l'utilisateur rentre un code postal de moins de 5 caractère, 
  cela renvoie sur un message d'erreur et non à la page de recherche.
- La recherche par plusieurs critères fonctionne desormais. 
-----
L'affichage du top 4 des restaurants sur la page d'accueil


# Fonctionnalité ajoutée :
Pouvoir cliquer sur les types de la page accueil afin d'acceder à la liste des restaurants avec ce type.

# Les fonctionnalités supprimés car non fonctionnelle

L.53 - vue/entête.html.php :
else {
?>
<li><a href="./?action=connexion"><img src="images/profil.png" alt="connexion"/>Connexion</a></li>
<?php }

Supprimée car :

- la connexion ne fonctionne pas.
- l'inscription se fait mal, le mail et le pseudo sont bien enregistrés mais le mdp n'est ni crypté ni enregistrée.
  (idU, mailU,             mdpU, pseudoU )
  (1, mgarnier@jolsio.net, NULL, mgarnier) exemple d'une enregistrement dans la table Utilisateur...

Je ne sais pas si le fait [d'aimer, commenter et de noter et de supprimer une critique] pour un restaurant fonctionne car ne pouvant pas me connecter à un utilisateur, cela est donc impossible de tester ces fonctionnalité.
