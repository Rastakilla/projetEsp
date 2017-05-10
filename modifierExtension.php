<?php
session_start();
include('connexionBd.php');
if (isset($_POST['ancienneExtension']) && isset($_POST['nouvelleExtension']) && isset($_SESSION['email']))
{
	$Extension = htmlentities($_POST['ancienneExtension']);
	$NouvelleExtension = htmlentities($_POST['nouvelleExtension']);
	include('connexionBd.php');
	$reponseExtension = $Cnn->prepare('select value from variable where nomVariable = "extensionCourriel";');
	$reponseExtension->execute();
	if($donneExtension = $reponseExtension->fetch())
	{
		if($Extension == $donneExtension['value'])
		{
			$reponseNouvelleExtension = $Cnn->prepare('Update variable set value  ="'.$NouvelleExtension.'" where nomVariable = "extensionCourriel";');
			$reponseNouvelleExtension ->execute();
			$_SESSION['Uploader'] = 'Extension modifiée avec succès';
		}
		else
		{
			$_SESSION['Uploader'] = 'Ancienne extension incorrecte';	
		}
		header('location:Gestionnaire.php');
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>