<?php
session_start();
include('connexionBd.php');
if (isset($_POST['ancienMdp']) && isset($_POST['nouveauMdp']) && isset($_POST['confirmationMdp']) && isset($_SESSION['email']))
{
	$MotDePasse = htmlentities($_POST['ancienMdp']);
	$NouveauMotDePasse = htmlentities($_POST['nouveauMdp']);
	$MotDePasseConfirmer = htmlentities($_POST['confirmationMdp']);
	include('connexionBd.php');
	$reponseMotDePasse = $Cnn->prepare('select mdp from gestionnaire where email ="'.$_SESSION['email'].'";');
	$reponseMotDePasse->execute();
	if($donneMotDePasse = $reponseMotDePasse->fetch())
	{
		if($MotDePasse == $donneMotDePasse['mdp'])
		{
			if($NouveauMotDePasse == $MotDePasseConfirmer)
			{
				$reponseNouveauMotDePasse = $Cnn->prepare('Update gestionnaire set mdp  ="'.$MotDePasseConfirmer.'"');
				$reponseNouveauMotDePasse ->execute();
				$_SESSION['Uploader'] = 'Mot de passe modifié avec succès';
				$_SESSION['mdp'] = $MotDePasseConfirmer;
			}
			else
			{
				$_SESSION['Uploader'] = 'Les mots de passes ne sont pas identiques';
			}
		}
		else
		{
			$_SESSION['Uploader'] = 'Ancien Mot de Passe incorrect';	
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