<?php
session_start();
echo 'hello';
if (isset($_POST['idEmprunt']) && isset($_POST['idOeuvre']))
{
	include('connexionBd.php');
	$id = $_POST['idEmprunt'];
	$DeleteEmprunt = $Cnn->prepare("update emprunt set confirme = 0 WHERE idEmprunt =".$id.";");
	$DeleteEmprunt->execute();
	
	$sql = 'select * from reservation where idOeuvre='.$_POST['idOeuvre'].' and effectif = 0 order by date limit 1;';
	$infoReserv = $Cnn->prepare($sql);
	$infoReserv->execute();
	if ($infoReserv->fetch() == false)
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
	header('Location : index.php');
}
?>