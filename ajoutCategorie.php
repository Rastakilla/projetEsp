<?php
session_start();
include('connexionBd.php');
if (isset($_POST['categorie']) && htmlentities($_POST['categorie'])&&isset($_GET['email']) && htmlentities($_GET['email']))
{
		 $ajouterCategorie = $Cnn->prepare('insert into categorie (nomCategorie) VALUES ("'.$_POST['mail'].'");');
		 $ajouterCategorie->execute();
		 	
		$_SESSION['Uploader'] = 'True';	
		
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
		 
}
else if(isset($_GET['email']) && htmlentities($_GET['email']))
{
       	$_SESSION['Uploader'] = 'Erreur pendant l\'ajout de la categorie';	
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
}
else
{
	header('location:index.php');
}
?>