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
	$sql = 'update oeuvres set idEtat = 6 where idOeuvres ='.$idOeuvre;
	$updateOeuvre = $Cnn->prepare($sql);
	$updateOeuvre->execute();
	$sql = 'insert into emprunt (Date,NomPersonneEmprunt,PrenomPersonneEmprunt,MailPersonneEmprunt,Local,idOeuvre) VALUES("'.date("Y-m-d H:i:s").'","'.$nom.'","'.$prenom.'","'.$mail.'","'.$local.'","'.$idOeuvre.'")';
	$_SESSION['type'] = $_GET['type'];	
}
else
{
	$_SESSION['acces'] = 'non';
}
//header('location:index.php');
?>