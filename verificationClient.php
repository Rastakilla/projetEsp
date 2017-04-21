<?PHP
session_start();
include('PHPMailer/PHPMailerAutoload.php');
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
 if($type == 'Reserver')
	{
				$sql = 'select count(*) nombre from (SELECT MailPersonneReserve FROM reservation where MailPersonneReserve = "'.$mail.'" and effectif = 1) as nombre;';
		$infoPersonne = $Cnn->prepare($sql);
		$infoPersonne->execute();
		$nombre;
		if ($nb = $infoPersonne->fetch())
		{
			$nombre = $nb['nombre'];
		}
		if ($nombre <2)
		{
			
			$sql = 'select idReservation from reservation where idOeuvre ='.$idOeuvre.' and effectif=1 and MailPersonneReserve = "'.$mail.'";';
			$infoReservationDuClient = $Cnn->prepare($sql);
			$infoReservationDuClient->execute();
			if ($infoReservationDuClient->fetch() == true)
			{
				$_SESSION['max'] = 'Vous avez déjà réserver cette oeuvre';
				header('location:index.php');
			}
			else
			{
				$sql = 'select idReservation from reservation where idOeuvre ='.$idOeuvre.' and effectif=1';
				$infoReserv = $Cnn->prepare($sql);
				$infoReserv->execute();
				$nb = 1;
				while ($nbOeuvre = $infoReserv->fetch())
				{
					$nb+=1;
				}
				
					$now = date('Y-m-d H:i:s');
					$sql = 'insert into reservation (Date,NomPersonneReserve,PrenomPersonneReserve,MailPersonneReserve,Local,idOeuvre,effectif) VALUES("'.$now.'","'.$nom.'","'.$prenom.'","'.$mail.'","'.$local.'","'.$idOeuvre.'",0)';
					$insertEmprunt = $Cnn->prepare($sql);
					$insertEmprunt->execute();
				
				
				$message = 'Cliquez sur le lien pour finaliser la réservation de l\'oeuvre. Prendre note que vous serrez la personne numéro '.$nb.' dans la liste d\'attente Si vous ne voulez plus celle-ci, ignorez ce message :<a href="localhost/'.$type.'.php?mail='.$mail.'&idOeuvre='.$idOeuvre.'&type='.$type.'&date='.$now.'">'.$type.'</a>' ;
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
				$mail->addAddress($mail);	
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
		}
		else
		{
			$_SESSION['max'] = 'Limite de réservation atteite (2). Vous ne pouvez réserver plus d\'oeuvres';
		}
	}
}
	header('Location: index.php');
?>