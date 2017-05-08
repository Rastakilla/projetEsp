<?php 
include ('/PHPMailer/PHPMailerAutoload.php');
include ('connexionBd.php');
echo $_POST['vMail'];
echo $_POST['vMessage'];
if (isset($_POST['vMail']) && isset($_POST['vMessage'])) 
{
	$Host;
	$Username;
	$Password;
	$Port;
	$Admin;
	$sql = 'select nomVariable,value from variable';
	$infoHost = $Cnn->prepare($sql);
	$infoHost->execute();
	while ($info = $infoHost->fetch())
	{
		if ($info['nomVariable'] == 'Host')
		{
			$Host = $info['value'];
		}
		else if ($info['nomVariable'] == 'Username')
		{
			$Username = $info['value'];
		}
		else if ($info['nomVariable'] == 'Password')
		{
			$Password = $info['value'];
		}
		else if ($info['nomVariable'] == 'Port')
		{
			$Port = $info['value'];
		}
		else if ($info['nomVariable'] == 'Admin')
		{
			$Admin = $info['value'];
		}
	}
	
	
	$email = $_POST['vMail']; 
	$message = $_POST['vMessage'].' de '.$email; 
	
	$mail = new PHPMailer;
		
	$mail->isSMTP();
	$mail->Host = $Host;
	$mail->SMTPAuth = true;
	$mail->Username = $Username;
	$mail->Password = $Password;
	$mail->Port = $Port;
	$mail->setFrom($email, $email);
	//$mail->setFrom(cpepin@cegepba.qc.ca, cpepin@cegepba.qc.ca);
	$mail->addAddress($Admin,$Admin);	
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Subject = 'Question section contactez-nous - Galerie des Arts Visuels';
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
	header('location:index.php?mail=true'); 
}
else
{
header('location:index.php?mail=false'); 
}?>