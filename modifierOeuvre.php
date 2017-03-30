<?php
session_start();
include('connexionBd.php');
if (isset($_POST['auteurM']) && htmlentities($_POST['auteurM'])&&isset($_GET['email']) && htmlentities($_GET['email']))
{
	$sql = 'Select idCategorie from categorie where nomCategorie ="'.$_POST['categorieM'].'"';
	$chercherCategories = $Cnn->prepare($sql);
	$chercherCategories->execute();
	if($chercherCategorie = $chercherCategories->fetch())
	{
		$categorie = $chercherCategorie['idCategorie'];
	}
	$sql = 'Select idetat from etat where NomEtat ="'.$_POST['etatM'].'"';
	$chercherEtats = $Cnn->prepare('Select idetat from etat where NomEtat ="'.$_POST['etatM'].'"');
	$chercherEtats->execute();
	if($chercherEtat = $chercherEtats->fetch())
	{
		$etat = $chercherEtat['idetat'];
	}
	$Profondeur = '';
	if($_POST['profondeurM'] != '')
	{
		$Profondeur = ',Profondeur='.$_POST["profondeurM"];
	}
	
	$sql = 'update oeuvres set Auteur = "'.$_POST["auteurM"].'",Hauteur='.$_POST["hauteurM"].',Largeur ='.$_POST["largeurM"].$Profondeur.',Titre="'.$_POST["titreM"].'",Annee='.$_POST["anneeM"].',idCategorie='.$categorie.',idEtat='.$etat.',lieu="'.$_POST["lieuM"].'",description="'.$_POST["descriptionM"].'" where idOeuvres = '.$_POST["idOeuvre"].';';
		 $ajouterGestionnaire = $Cnn->prepare($sql);
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