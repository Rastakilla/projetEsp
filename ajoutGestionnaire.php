<?php
session_start();
include('connexionBd.php');
if (isset($_POST['mail']) && htmlentities($_POST['mail'])&&isset($_GET['email']) && htmlentities($_GET['email']))
{
		 $ajouterGestionnaire = $Cnn->prepare('insert into gestionnaire (email) VALUES ("'.$_POST['mail'].'");');
		 $ajouterGestionnaire->execute();
		 	
		$_SESSION['Uploader'] = 'True';	
		
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
		 
}
else if(isset($_GET['email']) && htmlentities($_GET['email']))
{
       	$_SESSION['Uploader'] = 'Erreur pendant l\'ajout du gestionnaire';	
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