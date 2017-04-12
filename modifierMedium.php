<?php
session_start();
include('connexionBd.php');
if (isset($_POST['mediumModif'])&&isset($_SESSION['email']) && isset($_POST['idMedium']))
{
	
	$sql = 'update categorie set nomCategorie = "'.$_POST["mediumModif"].'" where idCategorie = "'.$_POST["idMedium"].'";';
		 $modifierMedium = $Cnn->prepare($sql);
		 $modifierMedium->execute();
		 	
		$_SESSION['Uploader'] = 'Modification du médium effectuée';	
		header('location:Gestionnaire.php');
		 
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>