<?php
// connexion à la BD
require_once("connect.php");

// moteur de templates Twig
include ('moteurtemplate.php');

// la classe Produit
include_once('Modules/produit.php');
// le manager (lien avec la BD)
include_once('Models/produitManager.php');

// manager de gestion des produits
$manager = new ProduitsManager($bdd);

// controleur 	
if (isset($_GET["action"])) {
  $action = $_GET["action"]; 
  switch ($action) {
	case "liste" :
		// liste des produits dans un tableau HTML
		$produits = $manager->getList(); // modèle
		echo $twig->render('listeproduit.html.twig', 
		                    array('produits' => $produits)); // viewer
		break;
	case "recher" :
		// affichage du formulaire de recherche
		echo $twig->render('rechercher.html.twig'); // viewer
		break;	
	case "valider_recher" :
		// traitement des critères de recherche et affichage des résultats
		$produits = $manager->search($_POST['libelle'],$_POST['prixmin'], $_POST['prixmax'] );
		echo $twig->render('listeproduit.html.twig', array('produits' => $produits)); 
		break;
	case "ajout" :
		// affichage du formulaire d'ajout
		echo $twig->render('ajoutproduit.html.twig');
		break;	
	case "valider_ajout" :
		// création d'un nouveau produit
		$produit = new Produit($_POST);
		// ajout du produit dans la base de données
		$ok = $manager->add($produit);
		// affichage d'un message d'état 
		if ($ok) { $message = "produit ajouté"; }
		else { $message = "pb lors de l'ajout";}
		echo $twig->render('index.html.twig', array('message' => $message));
		break;
	default;
  }
}
else {	
	echo $twig->render('index.html.twig'); 
	}
?>