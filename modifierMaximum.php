<?php
session_start();
include('connexionBd.php');
if (isset($_POST['maxReservation']) && isset($_POST['maxEmprunt']) && isset($_SESSION['email']))
{
	$maxReservation = htmlentities($_POST['maxReservation']);
	$maxEmprunt = htmlentities($_POST['maxEmprunt']);
	$sql = 'update variable set value ='.$maxReservation.' where nomVariable = "maxReservation";';
	$updateMax = $Cnn->prepare($sql);
	$updateMax->execute();
	$sql = 'update variable set value ='.$maxEmprunt.' where nomVariable = "maxEmprunt";';
	$updateMax = $Cnn->prepare($sql);
	$updateMax->execute();
	$_SESSION['Uploader'] = 'Changement de maximums effectué avec succès';
	header('location:Gestionnaire.php');
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>