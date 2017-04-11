<?PHP
session_start();
include('connexionBd.php');
if (isset($_GET['mail']) && isset($_GET['nom']) && isset($_GET['prenom']) && isset($_GET['local']) && isset($_GET['idOeuvre'])&& isset($_GET['type']))
{
	$mail = $_GET['mail'];
	$nom = $_GET['nom'];
	$prenom = $_GET['prenom'];
	$local = $_GET['local'];
	$idOeuvre = $_GET['idOeuvre'];
	$sql = 'select idReservation from reservation where idOeuvre ='.$idOeuvre;
	$infoReserv = $Cnn->prepare($sql);
	$infoReserv->execute();
	$sql = 'insert into reservation (Date,NomPersonneReserve,PrenomPersonneReserve,MailPersonneReserve,Local,idOeuvre) VALUES(NOW(),"'.$nom.'","'.$prenom.'","'.$mail.'","'.$local.'","'.$idOeuvre.'")';
	$insertEmprunt = $Cnn->prepare($sql);
	$insertEmprunt->execute();
	$_SESSION['type'] = $_GET['type'];
	/* TODO */
	//Faire l'envoie de mail automatique ici si le gars veut qu'un mail soit envoyer automatiquement à l'autre.
}
else
{
	$_SESSION['acces'] = 'non';
}
//header('location:index.php');
?>