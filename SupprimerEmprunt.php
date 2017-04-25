<?php
session_start();
if (isset($_POST['idEmprunt']) && isset($_POST['idOeuvre']))
{
	include('connexionBd.php');
	$id = $_POST['idEmprunt'];
	$DeleteEmprunt = $Cnn->prepare("DELETE FROM emprunt WHERE idEmprunt =".$id.";");
	$DeleteEmprunt->execute();
	
	$sql = 'select * from reservation where idOeuvre='.$id.' order by date limit 1;';
	$infoReserv = $Cnn->prepare($sql);
	$infoReserv->execute();
	if ($ReservationBonne = $infoReserv->fetch())
	{
		$sql = 'insert into emprunt (Date,NomPersonneEmprunt,PrenomPersonneEmprunt,MailPersonneEmprunt,Local,idOeuvre,confirme) VALUES(NOW(),"'.$ReservationBonne["NomPersonneReserve"].'","'.$ReservationBonne["PrenomPersonneReserve"].'","'.$ReservationBonne["MailPersonneReserve"].'","'.$ReservationBonne["Local"].'",'.$ReservationBonne["idOeuvre"].',0);';
		$changementEmprunt = $Cnn->prepare($sql);
		$changementEmprunt->execute();
	}
	else
	{
		$sql = 'select idetat from etat where peuxEtreReserve = 1;';
		$infoEtat = $Cnn->prepare($sql);
		$infoEtat->execute();
		if ($Etat = $infoEtat->fetch())
		{
		$sql = 'update oeuvres set idEtat = '.$Etat["idetat"].' where idOeuvres = '.$_POST['idOeuvre'];
		$updateOeuvre = $Cnn->prepare($sql);
		$updateOeuvre->execute();
		}
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>