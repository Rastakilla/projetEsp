<?php
session_start();
include('connexionBd.php');
if (isset($_POST['etat']) && htmlentities($_POST['etat']) && isset($_POST['reservation']) && htmlentities($_POST['reservation']))
{
	$peuxEtreReserve;
		if ($_POST['reservation'] == 'Non')
		{
			$peuxEtreReserve = '0';
		}
		else if ($_POST['reservation'] == 'Permet la réservation')
		{
			$peuxEtreReserve = '2';
		}
		else if ($_POST['reservation'] == "Permet l'emprunt")
		{
			$peuxEtreReserve = '1';
		}
		 $ajouterEtat = $Cnn->prepare('insert into etat (nomEtat,peuxEtreReserve) VALUES ("'.$_POST['etat'].'","'.$peuxEtreReserve.'");');
		 $ajouterEtat->execute();
		 	
		$_SESSION['Uploader'] = 'Ajout d\'État effectué';	
		header('location:Gestionnaire.php');
		 
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>