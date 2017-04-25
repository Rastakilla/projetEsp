<?php
session_start();
if (isset($_POST['idReservation']))
{
	include('connexionBd.php');
	$id = $_POST['idReservation'];
	$DeleteReserv = $Cnn->prepare("DELETE FROM reservation WHERE idReservation =".$id.";");
	$DeleteReserv->execute();
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>