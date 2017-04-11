<?PHP
session_start();
require '/PHPMailer/PHPMailerAutoload.php';
include('connexionBd.php');
if(!isset($_POST['email']) && !isset($_POST['mdp']))
{
	$_SESSION['acces'] = 'non';
}
else
{
	$email = $_POST['email'];
	$mdp = $_POST['mdp'];
	$verificateur = false;
	$reponseGestionnaire = $Cnn->prepare('SELECT email from gestionnaire where email="'.$email.'" and mdp="'.$mdp.'";');
	$reponseGestionnaire->execute();
		if ($reponseGestionnaire->fetch() == true)
		{
			$verificateur = true;
		}
	if ($verificateur == false)
	{
		$_SESSION['acces'] = 'non';
		header('location:index.php'); 
	}
	else
	{
		$_SESSION['email'] = $email;
		$_SESSION['mdp'] = $mdp;
		header('location:Gestionnaire.php'); 

	}
}
?>