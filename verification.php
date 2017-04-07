<?PHP
session_start();
require '/PHPMailer/PHPMailerAutoload.php';
include('connexionBd.php');
if(!isset($_POST['email']))
{
	$_SESSION['acces'] = 'non';
}
else
{
	$email = $_POST['email'];
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
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$email.'" ');
		$ajoutUniqId->execute();
		/*ENVOIE DU MAIL*/
	$message = 'Cliquez sur le lien pour aller dans l\'interface du gestionnaire : <a href="localhost/Gestionnaire.php?id='.$uniqId.'&email='.$email.'">Gestionnaire Site Web</a>'; 
	
		$mail = new PHPMailer;
			
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'infogalerievirtuellecba@gmail.com';
		$mail->Password = '$CBA436$';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->addAddress('cednoel@live.ca',$email);	
		$mail->isHTML(true);
		$mail->Subject = 'Partie Gestionnaire - Galerie des Arts Visuels';
		$mail->Body = $message;
		if(!$mail->send()) 
		{
			echo 'Message n\'a pas été envoyé.';
			echo 'Erreur Mailer: ' . $mail->ErrorInfo;
		} 
		else 
		{
			echo 'Message envoyé';
		}
	}
}
header('location:index.php'); 
?>