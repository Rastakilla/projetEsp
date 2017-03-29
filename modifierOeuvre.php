<?php
session_start();
include('connexionBd.php');
if (isset($_POST['auteurM']) && htmlentities($_POST['auteurM'])&&isset($_GET['email']) && htmlentities($_GET['email']))
{
		 $ajouterGestionnaire = $Cnn->prepare('update gestionnaire set Auteur = "'.$_POST['auteurM'].'",Hauteur="'.$_POST['hauteurM'].'",Largeur ="'.$_POST['largeurM'].'",Profondeur="'.$_POST['profondeurM'].'"');
		 $ajouterGestionnaire->execute();
		 	
		$_SESSION['Uploader'] = 'True';	
		
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
		 
}
else if(isset($_GET['email']) && htmlentities($_GET['email']))
{
       	$_SESSION['Uploader'] = 'Erreur pendant la modification';	
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