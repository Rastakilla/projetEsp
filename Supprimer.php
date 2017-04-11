<?php
session_start();
if (isset($_POST['idReservation']) && isset($_POST['idOeuvre']))
{
	include('connexionBd.php');
	$id = $_POST['idReservation'];
	$DeleteReserv = $Cnn->prepare("DELETE FROM reservation WHERE idReservation =".$id.";");
	$DeleteReserv->execute();
	$sql = 'select count(*) nombre from (select idOeuvre from reservation where idOeuvre ='.$_POST['idOeuvre'].') as infoCount';
	$infoCount = $Cnn->prepare($sql);
	$infoCount->execute();
	$nb;
	if ($count = $infoCount->fetch())
	{
		$nb = $count['nombre'];
	}
	if($nb == 0)
	{
		$sql = 'update oeuvres set idEtat = 3 where idOeuvres = '.$_POST['idOeuvre'];
		$updateOeuvre = $Cnn->prepare($sql);
		$updateOeuvre->execute();
	}
}
else
{
	$_SESSION['acces'] = 'non';
}
?>