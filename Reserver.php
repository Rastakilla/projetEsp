<?PHP
session_start();
include('connexionBd.php');
if (isset($_GET['mail']) && isset($_GET['idOeuvre'])&& isset($_GET['type']))
{
	$mail = $_GET['mail'];
	$idOeuvre = $_GET['idOeuvre'];
	$sql = 'Select Date from reservation where MailPersonneReserve ="'.$_GET['mail'].'" and idOeuvre ="'.$_GET['idOeuvre'].'" and effectif=0;';
	$DateBd;
	$infoDate = $Cnn->prepare($sql);
	$infoDate->execute();
	if ($Date = $infoDate->fetch())
	{
		$DateBd = $Date['Date'];
	}
	date_default_timezone_set('America/New_York');
	$DateNow = date('Y-m-d H:i:s');
	$date1Timestamp = strtotime($DateBd);
	$date2Timestamp = strtotime($DateNow);

	$difference = $date2Timestamp - $date1Timestamp;
	$difference = $difference/(60*60*24);
	if ($difference < 1)
	{
	$sql = 'update reservation set effectif = 1 where MailPersonneReserve = "'.$_GET['mail'].'" and idOeuvre = "'.$_GET['idOeuvre'].'";';
	$insertEmprunt = $Cnn->prepare($sql);
	$insertEmprunt->execute();
	$_SESSION['type'] = $_GET['type'];
	header('location:index.php');
	/* TODO */
	//Faire l'envoie de mail automatique ici si le gars veut qu'un mail soit envoyer automatiquement à l'autre.
	}
	else if ($difference >=1)
	{
		$sql = 'delete from reservation where MailPersonneReserve ="'.$_GET['mail'].'" and idOeuvre ="'.$_GET['idOeuvre'].'" and effectif=0;';
		$mettreCommanditaire = $Cnn->prepare($sql);
		$mettreCommanditaire->execute();
		$_SESSION['temps'] = 'Le delai de 24 heures a été dépassé. Une nouvelle demande est nécessaire pour pouvoir réserver l\'oeuvre.';
		header('location:index.php');
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>