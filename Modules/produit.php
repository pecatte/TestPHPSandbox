<?php
/**
* @author Jean-Marie Pecatte jean-marie.pecatte@iut-tlse3.fr
* @copyright MMI Castres
*/

/**
* Définition d'une classe permettant de gérer un produit
* en relation avec la base de données
*
*/
class Produit {
        private $_codep;
        private $_libelle;
        private $_prix;
        /**
		* contructeur : initialise le produit à partir d'un tableau de données
		* chaque case du tableau doit avoir comme indice le nom de la propriété
		* sans le $_
		*/
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }
        /**
        * initialisation d'un produit à partir d'un tableau de données 
        * [codep][libelle][prix]
        */
        public function hydrate(array $donnees) {
			if (isset($donnees['codep'])) { $this->_codep = $donnees['codep']; }
			if (isset($donnees['libelle'])) { $this->_libelle = $donnees['libelle']; }
			if (isset($donnees['prix'])) { $this->_prix = $donnees['prix']; }
        }            
        // GETTERS //
        public function codep() { return $this->_codep;}
		public function libelle() { return $this->_libelle;}
		public function prix() { return $this->_prix;}
		// SETTERS //
        public function setCodep($codep) { $this->_codep = $codep; }
        public function setLibelle($libelle) { $this->_libelle= $libelle; }
		public function setPrix($prix) { $this->_prix = $prix; }
    }


?>