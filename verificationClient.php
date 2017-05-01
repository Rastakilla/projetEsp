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
	$email = $_POST['emailClient'];
	$nom = $_POST['nomClient'];
	$prenom = $_POST['prenomClient'];
	$local = $_POST['localClient'];
	$type = $_GET['type'];
	$idOeuvre = $_GET['idOeuvre'];
	$message = '';
	$sql = 'select Titre from Oeuvres where idOeuvres = '.$idOeuvre;
	$infoTitre = $Cnn->prepare($sql);
	$infoTitre->execute();
	$titreOeuvre;
	if ($Titre = $infoTitre->fetch())
	{
		$titreOeuvre = $Titre['Titre'];
	}
 if($type == 'Reserver')
	{
				$sql = 'select count(*) nombre from (SELECT MailPersonneReserve FROM reservation where MailPersonneReserve = "'.$email.'" and effectif = 1) as nombre;';
		$infoPersonne = $Cnn->prepare($sql);
		$infoPersonne->execute();
		$nombre;
		if ($nb = $infoPersonne->fetch())
		{
			$nombre = $nb['nombre'];
		}
		if ($nombre <2)
		{
			
			$sql = 'select idReservation from reservation where idOeuvre ='.$idOeuvre.' and effectif=1 and MailPersonneReserve = "'.$email.'";';
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
					$sql = 'insert into reservation (Date,NomPersonneReserve,PrenomPersonneReserve,MailPersonneReserve,Local,idOeuvre,effectif) VALUES("'.$now.'","'.$nom.'","'.$prenom.'","'.$email.'","'.$local.'","'.$idOeuvre.'",0)';
					$insertEmprunt = $Cnn->prepare($sql);
					$insertEmprunt->execute();
				
				
				$message = 'Cliquez sur le lien pour finaliser la réservation de l\'oeuvre "'.$titreOeuvre.' ". Prendre note que vous serez la personne numéro '.$nb.' dans la liste d\'attente Si vous ne voulez plus celle-ci, ignorez ce message :<a href="http://localhost/'.$type.'.php?mail='.$email.'&idOeuvre='.$idOeuvre.'&type='.$type.'&date='.$now.'">'.$type.'</a>' ;
					/*ENVOIE DU MAIL*/
			
				$mail = new PHPMailer;
					
				$mail->isSMTP();
				$mail->Host = 'mail.kms-quebec.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'cba@kms-quebec.com';
				$mail->Password = 'Test1234';
				$mail->Port = 587;
				$mail->setFrom('infogalerievirtuellecba@gmail.com', 'Réservation GV');
				$mail->addAddress($email);	
				$mail->isHTML(true);
				$mail->CharSet = 'UTF-8';
				$mail->Subject = 'Réservation sur la Galerie des Arts Visuels';
				$mail->Body = $message;
				if(!$mail->send()) 
				{
						$_SESSION['max'] = $mail->ErrorInfo;
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