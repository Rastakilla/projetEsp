<?php
session_start();
include('connexionBd.php');
if (isset($_POST['reservationModif']) && isset($_POST['EtatModif'])&& isset($_POST['idEtat']))
{
	$peuxEtreReserve;
		if ($_POST['reservationModif'] == 'Ne peux être reservée ou empruntée')
		{
			$peuxEtreReserve = '0';
		}
		else if ($_POST['reservationModif'] == 'Peux être empruntée')
		{
			$peuxEtreReserve = '1';
		}
		else if ($_POST['reservationModif'] == 'Peux être reservée')
		{
			$peuxEtreReserve = '2';
		}
	
	$sql = 'update etat set NomEtat = "'.$_POST["EtatModif"].'",peuxEtreReserve = "'.$peuxEtreReserve.'" where idetat = "'.$_POST["idEtat"].'";';
		 $ajouterGestionnaire = $Cnn->prepare($sql);
		 $ajouterGestionnaire->execute();
		 	
		$_SESSION['Uploader'] = 'Modification d\'état effectuée';	
		
		header('location:Gestionnaire.php');
		 
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>