<?php
namespace modele\metier;

class TypesCuisine {
    /** @var int identifiant de type de cuisine */
    private ?int $idTC;
    /** @var string libelle des differents types de cuisines */
    private ?string $libelleTC;

    
    //création du constructeur pour la class typecuisine
    function __construct(int $idTC, string $libelleTC) {
        $this->idTC = $idTC;
        $this->libelleTC = $libelleTC;
    }
    
    
    //création des accesseurs :
    function getIdTC(): ?int {
        return $this->idTC;
    }
    
    function getLibelleTC(): ?string {
        return $this->libelleTC;
    }
    
    //création des mutateurs :
    function setIdTC(int $idTC): void {
        $this->idTC = $idTC;
    }

    function setLibelleTC(string $libelleTC): void {
        $this->libelleTC = $libelleTC;
    }
}
