<?php
session_start();
include('connexionBd.php');
if (isset($_POST['maxReservation']) && isset($_POST['maxEmprunt']) && isset($_SESSION['email']))
{
	$maxReservation = htmlentities($_POST['maxReservation']);
	$maxEmprunt = htmlentities($_POST['maxEmprunt']);
	$sql = 'update variable set maxReservation ='.$maxReservation.', maxEmprunt = '.$maxEmprunt;
	$updateMax = $Cnn->prepare($sql);
	$updateMax->execute();
	$_SESSION['Uploader'] = 'Changement de maximums effectué avec succès';
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>