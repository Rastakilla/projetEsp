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
				$sql = 'select count(*) nombre from (SELECT MailPersonneReserve FROM reservation where MailPersonneReserve = "'.$mail.'") as nombre;';
		$infoPersonne = $Cnn->prepare($sql);
		$infoPersonne->execute();
		$nombre;
		if ($nb = $infoPersonne->fetch())
		{
			$nombre = $nb['nombre'];
		}
		if ($nombre <2)
		{
			$sql = 'select idReservation from reservation where idOeuvre ='.$idOeuvre;
			$infoReserv = $Cnn->prepare($sql);
			$infoReserv->execute();
			$nb = 0;
				while ($nbOeuvre = $infoReserv->fetch())
				{
					$nb+=1;
				}
				
				$message = 'Cliquez sur le lien pour finaliser la réservation de l\'oeuvre. Prendre note que vous serrez la personne numéro '.$nb.' dans la liste d\'attente Si vous ne voulez plus celle-ci, ignorez ce message : '.$type.'.php?mail='.$mail.'&nom='.$nom.'&prenom='.$prenom.'&local='.$local.'&idOeuvre='.$idOeuvre.'&type='.$type;
					/*ENVOIE DU MAIL*/
			
				$mail = new PHPMailer;
					
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'infogalerievirtuellecba@gmail.com';
				$mail->Password = '$CBA436$';
				$mail->SMTPSecure = 'ssl';
				$mail->Port = 465;
				$mail->setFrom('infogalerievirtuellecba@gmail.com', 'Réservation GV');
				$mail->addAddress('cednoel@live.ca');	
				$mail->isHTML(true);
				$mail->CharSet = 'UTF-8';
				$mail->Subject = 'Réservation sur la Galerie des Arts Visuels';
				$mail->Body = $message;
				if(!$mail->send()) 
				{
						$_SESSION['acces'] = 'non';
					echo 'Message n\'a pas été envoyé.';
					echo 'Erreur Mailer: ' . $mail->ErrorInfo;
				} 
				else 
				{
						$_SESSION['acces'] = 'oui';
					echo 'Message envoyé';
				}
		}
		else
		{
			$_SESSION['max'] = 'Limite de réservation atteite (2). Vous ne pouvez réserver plus d\'oeuvres';
		}
	}
}
	header('Location: index.php');
?>