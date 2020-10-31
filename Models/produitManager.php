<?php
	
/**
* Définition d'une classe permettant de gérer les produits 
*   en relation avec la base de données	
*/
class ProduitsManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
		* ajout d'un produit dans la BD
		* @param produit à ajouter
		* @return  true si l'ajout a bien eu lieu, false sinon
		*/
        public function add(Produit $produit) {
            // calcul d'un nouveau code produit non déja utilisé = Maximum + 1
			$stmt = $this->_db->prepare("SELECT MAX(CODEP) AS MAXIMUM FROM produit");
			$stmt->execute();
            $produit->setCodep($stmt->fetchColumn()+1);
            
            // requete d'ajout dans la BD
			$req = "INSERT INTO produit (codep,libelle,prix) VALUES (?,?,?)";
			$stmt = $this->_db->prepare($req);
			$res  = $stmt->execute(array($produit->codep(),$produit->libelle(),$produit->prix()));		
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
            return $res;
        }
        /**
		* nombre de produits dans la base de données
		* @return int le nb de produits
		*/
        public function count() {
            $stmt = $this->_db->prepare('SELECT COUNT(*) FROM produit');
			$stmt->execute();
			return $stmt->fetchColumn();
        }
        /**
		* suppression d'un produit dans la base de données
		* @param Produit 
		* @return boolean true si suppression, false sinon
		*/
        public function delete(Produit $produit) {
            $req = "DELETE FROM produit WHERE codep =  ?";
			$stmt = $this->_db->prepare($req);
            return $stmt->execute(array($produit->codep()));
        }
        /**
		* recherche dans la BD d'un produit à partir de son code
		* @param int $codep
		* @return Produit 
		*/
		public function get($codep) {
            $req = 'SELECT codep, libelle, prix FROM produit WHERE codep=?';
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($codep));
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$iti = new Produit($stmt->fetch());
            return $iti;
        }
        /**
		* retourne l'ensemble des produits présents dans la BD 
		* @return Produit[]
		*/		
        public function getList() {
            $produits = array();
			$req = "SELECT codep, libelle, prix FROM produit";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			// récup des données
            while ($donnees = $stmt->fetch())
            {
                $produits[] = new Produit($donnees);
            }
            return $produits;
        }
        /**
		* méthode de recherche d'itinéraires dans la BD à partir des critères passés en paramètre
		* @param string $libelle
		* @param string $prixmin
		* @param string $prixmax
		* @return Produit[]
		*/
		public function search($libelle, $prixmin, $prixmax)
		{
			$req = "SELECT codep, libelle, prix FROM produit";
			$cond = '';

			if ($libelle<>"") 
			{ 	$cond = $cond . " libelle like '%". $libelle ."%'";
			}
			if ($prixmin<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " prix >=" . $prixmin;
			}
			if ($prixmax<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " prix <=" . $prixmax;
			}
			if ($cond <>"")
			{ 	$req .= " WHERE " . $cond;
			}

            // execution de la requete				
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$itineraires = array();
			while ($donnees = $stmt->fetch())
            {
                $produits[] = new Produit($donnees);
            }
            return $produits;
		}
        /**
		* modification d'un produit dans la BD
		* @param Produit
		* @return boolean 
		*/
        public function update(Produit $produit)
        {
            $req = "UPDATE PRODUIT SET libelle=?, prix=? WHERE codep=?";
            $stmt = $this->_db->prepare($req);
            $stmt->execute(array($roduit->libelle(),$produit->prix(),$produit->codep() ));
            return $stmt->rowCount();
			
        }
    }

?>