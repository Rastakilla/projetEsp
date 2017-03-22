<?PHP
session_start();
include('connexionBd.php');
if(!isset($_GET['email']))
{
	$_SESSION['acces'] = 'non';
}
else if(htmlentities($_GET['email']))
{
	$email = htmlentities($_GET['email']);
	$verificateur = false;
	$reponseGestionnaire = $Cnn->prepare('SELECT email from gestionnaire;');
	$reponseGestionnaire->execute();
	while($infoGestionnaire = $reponseGestionnaire->fetch())
	{
		if ($email == $infoGestionnaire['email'])
		{
			$verificateur = true;
		}
	}
	if ($verificateur == false)
	{
		$_SESSION['acces'] = 'non';
	}
	else
	{
		$_SESSION['acces'] = 'oui';
		//mail('cednoel@live.ca','Verification de Gestionnaire','Cliquez sur le lien pour aller dans l\'interface du gestionnaire : Gestionnaire.php?email='.$email.' ');
	header('Location: Gestionnaire.php?email='.$email);
	}
}
//header('Location: index.php');
?>