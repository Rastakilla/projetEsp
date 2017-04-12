<?php
session_start();

include('connexionBd.php');
if (isset($_POST['medium'])&&isset($_SESSION['email'])&&isset($_SESSION['mdp']))
{
		 $ajouterCategorie = $Cnn->prepare('insert into categorie (nomCategorie) VALUES ("'.$_POST['medium'].'");');
		 $ajouterCategorie->execute();
		 	
		$_SESSION['Uploader'] = 'Ajout du médium effectué';	
		
		header('location:Gestionnaire.php');
		 
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>