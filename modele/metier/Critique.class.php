<?php
namespace modele\metier;
use modele\metier\Utilisateur;

/**
 * Description of Critique
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class Critique {
    /** @var int note sur 5 en points entiers déposée par l'utilisateur */
    private ?int $note;
    /** @var string commentaire déposé par l'utilisateur */
     private ?string $commentaire;
    /** @var Utilisateur utilisateur auteur de la critique */
     private Utilisateur $leUtilisateur;
    
     function __construct(?int $note, ?string $commentaire, Utilisateur $unUtil) {
         $this->note = $note;
         $this->commentaire = $commentaire;
         $this->leUtilisateur = $unUtil;
     }

    function getNote(): ?int {
        return $this->note;
    }

    function getCommentaire(): ?string {
        return $this->commentaire;
    }

    function setNote(?int $note): void {
        $this->note = $note;
    }

    function setCommentaire(?string $commentaire): void {
        $this->commentaire = $commentaire;
    }

    function getLeUtilisateur(): Utilisateur {
        return $this->leUtilisateur;
    }

    function setLeUtilisateur(Utilisateur $leUtilisateur): void {
        $this->leUtilisateur = $leUtilisateur;
    }


    
}
