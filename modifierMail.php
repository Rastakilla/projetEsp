<?php
session_start();
include('connexionBd.php');
if (isset($_POST['ancienMail']) && isset($_POST['nouveauMail']) && isset($_SESSION['email']))
{
	$Mail = htmlentities($_POST['ancienMail']);
	$NouveauMail = htmlentities($_POST['nouveauMail']);
	include('connexionBd.php');
	$reponseMail = $Cnn->prepare('select email from gestionnaire;');
	$reponseMail->execute();
	if($donneMail = $reponseMail->fetch())
	{
		if($Mail == $donneMail['email'])
		{
			$reponseNouveauMail = $Cnn->prepare('Update gestionnaire set email  ="'.$NouveauMail.'"');
			$reponseNouveauMail ->execute();
			$_SESSION['Uploader'] = 'Mail Admin modifié avec succès';
			$_SESSION['email'] = $NouveauMail;
		}
		else
		{
			$_SESSION['Uploader'] = 'Ancien Mail incorrect';	
		}
		header('location:Gestionnaire.php');
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>