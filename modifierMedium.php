<?php
session_start();
include('connexionBd.php');
if (isset($_POST['mediumModif'])&&isset($_GET['email']) && isset($_POST['idMedium']))
{
	
	$sql = 'update categorie set nomCategorie = "'.$_POST["mediumModif"].'" where idCategorie = "'.$_POST["idMedium"].'";';
		 $modifierMedium = $Cnn->prepare($sql);
		 $modifierMedium->execute();
		 	
		$_SESSION['Uploader'] = 'Modification du médium effectuée';	
		
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