<?PHP
session_start();
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
		//mail($_POST['emailClient'],'Verification de Client','Cliquez sur le lien pour finaliser l\'emprunt de l\'oeuvre. Si vous ne voulez plus celle-ci, ignorez ce message. : '.$type.'.php?mail='.$mail.'&nom='.$nom.'&prenom='.$prenom.'&local='.$local.'&idOeuvre='.$idOeuvre.'&type='.$type);
	header('Location: '.$type.'.php?mail='.$mail.'&nom='.$nom.'&prenom='.$prenom.'&local='.$local.'&idOeuvre='.$idOeuvre.'&type='.$type);
}
	//header('Location: index.php');
?>