<?php
session_start();

include('connexionBd.php');
if (isset($_POST['categorie']) && htmlentities($_POST['categorie'])&&isset($_SESSION['email']) && htmlentities($_SESSION['email'])&&isset($_SESSION['mdp']) && htmlentities($_SESSION['mdp']))
{
		 $ajouterCategorie = $Cnn->prepare('insert into categorie (nomCategorie) VALUES ("'.$_POST['categorie'].'");');
		 $ajouterCategorie->execute();
		 	
		$_SESSION['Uploader'] = 'Ajout du médium effectué';	
		
		header('location:Gestionnaire.php');
		 
}
else
{
	header('location:index.php');
}
?>