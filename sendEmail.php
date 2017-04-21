<?php 
include ('/PHPMailer/PHPMailerAutoload.php');
echo $_POST['vMail'];
echo $_POST['vMessage'];
if (isset($_POST['vMail']) && isset($_POST['vMessage'])) 
{
	$email = $_POST['vMail']; 
	$message = $_POST['vMessage'].' de '.$email; 
	
	$mail = new PHPMailer;
		
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'infogalerievirtuellecba@gmail.com';
	$mail->Password = '$CBA436$';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->setFrom($email, $email);
	//$mail->setFrom(cpepin@cegepba.qc.ca, cpepin@cegepba.qc.ca);
	$mail->addAddress('ypaquin@cegepba.qc.ca','ypaquin@cegepba.qc.ca');	
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