<?PHP
session_start();
require '/PHPMailer/PHPMailerAutoload.php';
include('connexionBd.php');
if(!isset($_GET['type']) || !isset($_POST['emailClient']) )
{
	$_SESSION['acces'] = 'non';
}
else if(isset($_POST['emailClient']) && isset($_POST['nomClient']) && isset($_POST['prenomClient']) && isset($_POST['localClient']))
{
	$_SESSION['acces'] = 'oui';
	$mail = $_POST['emailClient'];
	$nom = $_POST['nomClient'];
	$prenom = $_POST['prenomClient'];
	$local = $_POST['localClient'];
	$type = $_GET['type'];
	$idOeuvre = $_GET['idOeuvre'];
	$message = '';
	if($type == 'Emprunter')
	{
		$message = 'Cliquez sur le lien pour finaliser l\'emprunt de l\'oeuvre. Si vous ne voulez plus celle-ci, ignorez ce message. : '.$type.'.php?mail='.$mail.'&nom='.$nom.'&prenom='.$prenom.'&local='.$local.'&idOeuvre='.$idOeuvre.'&type='.$type;
	}
	else if($type == 'Reserver')
	{
	$sql = 'select idReservation from reservation where idOeuvre ='.$idOeuvre;
	$infoReserv = $Cnn->prepare($sql);
	$infoReserv->execute();
	$nb = 0;
	while ($nbOeuvre = $infoReserv->fetch())
	{
		$nb+=1;
	}
		$message = 'Cliquez sur le lien pour finaliser la reservation de l\'oeuvre. Si vous ne voulez plus celle-ci, ignorez ce message. De plus, prendre note que vous êtes la personne numéro '.$nb.' dans la liste d\'attente : '.$type.'.php?mail='.$mail.'&nom='.$nom.'&prenom='.$prenom.'&local='.$local.'&idOeuvre='.$idOeuvre.'&type='.$type;
	}
		//mail($_POST['emailClient'],'Verification de Client',$message);
	header('Location: '.$type.'.php?mail='.$mail.'&nom='.$nom.'&prenom='.$prenom.'&local='.$local.'&idOeuvre='.$idOeuvre.'&type='.$type);
}
	//header('Location: index.php');
?>