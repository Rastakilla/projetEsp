<?php
session_start();
include('connexionBd.php');
if (isset($_POST['reservationModif'])&&isset($_GET['email']) && isset($_POST['EtatModif'])&& isset($_POST['idEtat']))
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