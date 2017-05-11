<?PHP
session_start();
include('connexionBd.php');
if (isset($_GET['mail']) && isset($_GET['idOeuvre'])&& isset($_GET['type'])&& isset($_GET['date']))
{
	$sql = 'select idOeuvre from reservation where MailPersonneReserve ="'.$_GET['mail'].'" and idOeuvre ="'.$_GET['idOeuvre'].'" and effectif = 1;';
	$infoOeuvre = $Cnn->prepare($sql);
	$infoOeuvre->execute();
	if($infoOeuvre->fetch() == false)
	{
		$sql = 'select count(*) nombre from (SELECT MailPersonneReserve FROM reservation where MailPersonneReserve = "'.$_GET['mail'].'" and effectif = 1) as nombre;';
		$infoPersonne = $Cnn->prepare($sql);
		$infoPersonne->execute();
		$nombre;
		if ($nb = $infoPersonne->fetch())
		{
			$nombre = $nb['nombre'];
		}
		
		$maxReservation;
		$sql = 'select value from variable where nomVariable = "maxReservation"';
		$infoReserv = $Cnn->prepare($sql);
		$infoReserv->execute();
		if ($info = $infoReserv->fetch())
		{
			$maxReservation = $info['value'];
		}
			$sql = 'select email from gestionnaire';
			$infoGestionnaire = $Cnn->prepare($sql);
			$infoGestionnaire->execute();
			$mailGestionnaire;
			if ($Gestionnaire = $infoGestionnaire->fetch())
			{
				$mailGestionnaire = $Gestionnaire['email'];
			}
				
		if ($nombre <$maxReservation || $mailGestionnaire == $_GET['mail'])
		{
			$mail = $_GET['mail'];
			$idOeuvre = $_GET['idOeuvre'];
			$DateBd = $_GET['date'];
			date_default_timezone_set('America/New_York');
			$DateNow = date('Y-m-d H:i:s');
			$date1Timestamp = strtotime($DateBd);
			$date2Timestamp = strtotime($DateNow);
		
			$difference = $date2Timestamp - $date1Timestamp;
			$difference = $difference/(60*60*24);
			if ($difference < 1)
			{
			$sql = 'update reservation set effectif = 1 where MailPersonneReserve = "'.$_GET['mail'].'" and idOeuvre = "'.$_GET['idOeuvre'].'" and Date = "'.$DateBd.'";';
			$insertEmprunt = $Cnn->prepare($sql);
			$insertEmprunt->execute();

			$_SESSION['type'] = $_GET['type'];
			header('location:index.php');
			}
			else if ($difference >=1)
			{
				$sql = 'delete from reservation where MailPersonneReserve ="'.$_GET['mail'].'" and idOeuvre ="'.$_GET['idOeuvre'].'" and effectif=0 and Date="'.$_GET['date'].'";';
				$deleteReserv = $Cnn->prepare($sql);
				$deleteReserv->execute();
				$_SESSION['temps'] = 'Le delai de 24 heures a été dépassé. Une nouvelle demande est nécessaire pour pouvoir réserver l\'oeuvre.';
				header('location:index.php');
			}
		}
		else
		{
			$sql = 'delete from reservation where MailPersonneReserve ="'.$_GET['mail'].'" and idOeuvre ="'.$_GET['idOeuvre'].'" and effectif=0;';
			$deleteReserv = $Cnn->prepare($sql);
			$deleteReserv->execute();
			$_SESSION['max'] = 'Limite de réservation atteinte ('.$maxReservation.'). Vous ne pouvez réserver plus d\'oeuvres';
			header('location:index.php');
		}
	}
	else
	{
			$sql = 'delete from reservation where MailPersonneReserve ="'.$_GET['mail'].'" and idOeuvre ="'.$_GET['idOeuvre'].'" and effectif=0;';
			$deleteReserv = $Cnn->prepare($sql);
			$deleteReserv->execute();
		$_SESSION['max'] = 'Vous avez déjà réserver cette oeuvre';
		header('location:index.php');
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>