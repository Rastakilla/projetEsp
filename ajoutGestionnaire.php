<?php
session_start();
include('connexionBd.php');
if (isset($_POST['mail']) && htmlentities($_POST['mail'])&&isset($_SESSION['email']))
{
		 $ajouterGestionnaire = $Cnn->prepare('insert into gestionnaire (email) VALUES ("'.$_POST['mail'].'");');
		 $ajouterGestionnaire->execute();
		 	
		$_SESSION['Uploader'] = 'Ajout du gestionnaire effectué';	
		
		header('location:Gestionnaire.php');
		 
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>