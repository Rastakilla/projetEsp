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
		$sql = 'select * from reservation where idOeuvre='.$_POST["idOeuvre"].' and effectif = 1 and MailPersonneReserve = "'.$_POST['mail'].'"';
		$infoReservation = $Cnn->prepare($sql);
		$infoReservation->execute();
		$idReservation=0;
		$sql2 = '';
		$local = '';
		$nb = 0;
		$choix;
		if ($_POST['deplacement'] == 'true')
		{
			$choix = '0';
		}
		else if ($_POST['deplacement'] == 'false')
		{
			$choix = '1';
		}
		if ($Reservation = $infoReservation->fetch())
		{
			$idReservation = $Reservation['idReservation'];
			$local = $Reservation["Local"];
			$sql2 = 'insert into emprunt (Date,NomPersonneEmprunt,PrenomPersonneEmprunt,MailPersonneEmprunt,Local,idOeuvre,confirme,FinAnnee) VALUES(NOW(),"'.$Reservation["NomPersonneReserve"].'","'.$Reservation["PrenomPersonneReserve"].'","'.$Reservation["MailPersonneReserve"].'","'.$Reservation["Local"].'",'.$_POST["idOeuvre"].',1,'.$choix.')';
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