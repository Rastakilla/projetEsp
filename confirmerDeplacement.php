<?PHP
session_start();
include('connexionBd.php');
if (isset($_POST['idOeuvre']) && isset($_POST['choice']))
{
	$choice = $_POST['choice'];
	if ($choice == 'true')
	{
		$sql1 = 'select idetat from etat where peuxEtreReserve = 1';
		$infoEtat = $Cnn->prepare($sql1);
		$infoEtat->execute();
		$idEtat = 1;
		if ($Etat = $infoEtat->fetch())
		{
			$idEtat = $Etat['idetat'];
		}
		$sql = 'update Oeuvres set lieu = "Entrepôt",idEtat ='.$idEtat.' where idOeuvres='.$_POST["idOeuvre"].';';
		$majOeuvre = $Cnn->prepare($sql);
		$majOeuvre->execute();
		$sql = 'Delete from emprunt where idOeuvre = '.$_POST["idOeuvre"];
		$majEmprunt = $Cnn->prepare($sql);
		$majEmprunt->execute();
	}
	else if($choice == 'false')
	{
		$sql = 'Delete from emprunt where idOeuvre = '.$_POST["idOeuvre"];
		$majEmprunt = $Cnn->prepare($sql);
		$majEmprunt->execute();
		$sql = 'select * from reservation where idOeuvre='.$_POST["idOeuvre"].' and effectif = 1 order by date limit 1';
		$infoReservation = $Cnn->prepare($sql);
		$infoReservation->execute();
		$idReservation=0;
		$sql2 = '';
		$local = '';
		$nb = 0;
		if ($Reservation = $infoReservation->fetch())
		{
			$idReservation = $Reservation['idReservation'];
			$local = $Reservation["Local"];
			$sql3 = 'Select count(*) as nb from emprunt where MailPersonneEmprunt = "'.$Reservation["MailPersonneReserve"].'"';
			$infoNb = $Cnn->prepare($sql3);
			$infoNb->execute();
			if ($nombre = $infoNb->fetch())
			{
				$nb = $nombre['nb'];
			}
			if ($nb >= 2)
			{
				$sql4 = 'update  emprunt set confirme = 0 where MailPersonneEmprunt = "'.$Reservation["MailPersonneReserve"].'" and Date = ( select date from (select date from emprunt where MailPersonneEmprunt = "'.$Reservation["MailPersonneReserve"].'" order by date asc limit 1) as c)';
				$updateEmprunt = $Cnn->prepare($sql4);
				$updateEmprunt->execute();
			}
			$sql2 = 'insert into emprunt (Date,NomPersonneEmprunt,PrenomPersonneEmprunt,MailPersonneEmprunt,Local,idOeuvre,confirme) VALUES(NOW(),"'.$Reservation["NomPersonneReserve"].'","'.$Reservation["PrenomPersonneReserve"].'","'.$Reservation["MailPersonneReserve"].'","'.$Reservation["Local"].'",'.$_POST["idOeuvre"].',1)';
		}
		$ajoutEmprunt = $Cnn->prepare($sql2);
		$ajoutEmprunt->execute();
		$sql = 'delete from reservation where idReservation = '.$idReservation;
		$delReservation = $Cnn->prepare($sql);
		$delReservation->execute();
		$sql = 'update Oeuvres set lieu = "'.$local.'" where idOeuvres='.$_POST["idOeuvre"].';';
		$majOeuvre = $Cnn->prepare($sql);
		$majOeuvre->execute();
	}
}
else
{
	$_SESSION['acces'] = 'non';
}
header('location:index.php');
?>