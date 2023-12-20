<?php

namespace modele\metier;

/**
 * Description of Photo
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class Photo {
    private int $idP;
    private string $cheminP;
    
    function __construct(int $idP, string $cheminP) {
        $this->idP = $idP;
        $this->cheminP = $cheminP;
    }
    function getIdP(): int {
        return $this->idP;
    }

    function getCheminP(): string {
        return $this->cheminP;
    }

    function setIdP(int $idP): void {
        $this->idP = $idP;
    }

    function setCheminP(string $cheminP): void {
        $this->cheminP = $cheminP;
    }


}
