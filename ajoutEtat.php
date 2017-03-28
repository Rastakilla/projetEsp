<?php
session_start();
include('connexionBd.php');
if (isset($_POST['etat']) && htmlentities($_POST['etat']) && isset($_POST['reservation']) && htmlentities($_POST['reservation'])&&isset($_GET['email']) && htmlentities($_GET['email']))
{
	$peuxEtreReserve;
		if ($_POST['reservation'] == 'Oui')
		{
			$peuxEtreReserve = '1';
		}
		else if ($_POST['reservation'] == 'Non')
		{
			$peuxEtreReserve = '0';
		}
		 $ajouterEtat = $Cnn->prepare('insert into etat (nomEtat,peuxEtreReserve) VALUES ("'.$_POST['etat'].'","'.$peuxEtreReserve.'");');
		 $ajouterEtat->execute();
		 	
		$_SESSION['Uploader'] = 'True';	
		
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
		 
}
else if (isset($_GET['email']) && htmlentities($_GET['email']))
{
       	$_SESSION['Uploader'] = 'Erreur pendant l\'ajout de l\'etat';	
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