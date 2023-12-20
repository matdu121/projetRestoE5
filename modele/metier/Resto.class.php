<?php
namespace modele\metier;

/**
 * Description of Resto
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class Resto {
    /** @var int identifiant du restaurant */
    private int $idR;
    /** @var string nom du restaurant */
    private ?string $nomR;
    /** @var string adresse : n° dans la voie */
    private ?string $numAdr;
    /** @var string adresse : nom de la voie */
    private ?string $voieAdr;
    /** @var string adresse : code postal */
    private ?string $cpR;
    /** @var string adresse : nom de la ville */
    private ?string $villeR;
    /** @var float position : latitude en degrés */
    private ?float $latitudeDegR;
    /** @var float position : longitude en degrés */
    private ?float $longitudeDegR;
    /** @var string description du restaurant */
    private ?string $descR;
    /** @var string texte HTML d'affichage des horaires d'ouverture */
    private ?string $horairesR;
    /** @var array() tableau d'objets Photo : les photos du restaurant ; la photo principale en 1ère position */
    private array $lesPhotos;
    /** @var array() tableau d'objets Critique : les notes et commentaires déposées par les utilisateurs sur le restaurant */
    private array $lesCritiques;
    private array $lesTypesCuisine;

      
    function __construct(int $idR, string $nomR, ?string $numAdr, ?string $voieAdr, ?string $cpR, ?string $villeR, ?float $latitudeDegR, ?float $longitudeDegR, ?string $descR, ?string $horairesR) {
        $this->idR = $idR;
        $this->nomR = $nomR;
        $this->numAdr = $numAdr;
        $this->voieAdr = $voieAdr;
        $this->cpR = $cpR;
        $this->villeR = $villeR;
        $this->latitudeDegR = $latitudeDegR;
        $this->longitudeDegR = $longitudeDegR;
        $this->descR = $descR;
        $this->horairesR = $horairesR;
        $this->lesCritiques = array();
        $this->lesPhotos = array();
        $this->lesTypesCuisine = array();
    }
    
    
    public function getLesTypesCuisine(): array {
        return $this->lesTypesCuisine;
    }

    public function setLesTypesCuisine(array $lesTypesCuisine): void {
        $this->lesTypesCuisine = $lesTypesCuisine;
    }

    
    function getIdR(): int {
        return $this->idR;
    }

    function getNomR(): ?string {
        return $this->nomR;
    }

    function getNumAdr(): ?string {
        return $this->numAdr;
    }

    function getVoieAdr(): ?string {
        return $this->voieAdr;
    }

    function getCpR(): ?string {
        return $this->cpR;
    }

    function getVilleR(): ?string {
        return $this->villeR;
    }

    function getLatitudeDegR(): ?float {
        return $this->latitudeDegR;
    }

    function getLongitudeDegR(): ?float {
        return $this->longitudeDegR;
    }

    function getDescR(): ?string {
        return $this->descR;
    }

    function getHorairesR(): ?string {
        return $this->horairesR;
    }

    function getLesPhotos(): array {
        return $this->lesPhotos;
    }

    function getLesCritiques(): array {
        return $this->lesCritiques;
    }
    
   

    function setIdR(int $idR): void {
        $this->idR = $idR;
    }

    function setNomR(string $nomR): void {
        $this->nomR = $nomR;
    }

    function setNumAdr(string $numAdr): void {
        $this->numAdr = $numAdr;
    }

    function setVoieAdr(string $voieAdr): void {
        $this->voieAdr = $voieAdr;
    }

    function setCpR(string $cpR): void {
        $this->cpR = $cpR;
    }

    function setVilleR(string $villeR): void {
        $this->villeR = $villeR;
    }

    function setLatitudeDegR(float $latitudeDegR): void {
        $this->latitudeDegR = $latitudeDegR;
    }

    function setLongitudeDegR(float $longitudeDegR): void {
        $this->longitudeDegR = $longitudeDegR;
    }

    function setDescR(string $descR): void {
        $this->descR = $descR;
    }

    function setHorairesR(string $horairesR): void {
        $this->horairesR = $horairesR;
    }

    function setLesPhotos(array $lesPhotos): void {
        $this->lesPhotos = $lesPhotos;
    }

    function setLesCritiques(array $lesCritiques): void {
        $this->lesCritiques = $lesCritiques;
    }
}
