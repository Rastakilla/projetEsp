<?php
session_start();
if (isset($_POST['from']) && isset($_POST['mdp']) && isset($_POST['host']) && isset($_POST['username']) && isset($_POST['port']))
{
	$utilisateur = htmlentities($_POST['username']);
	$from = htmlentities($_POST['from']);
	$mdp = htmlentities($_POST['mdp']);
	$host = htmlentities($_POST['host']);
	$port = htmlentities($_POST['port']);
	include('connexionBd.php');
	$sql = 'update variable set value ="'.$from.'" where nomVariable = "From";';
	$majServeur = $Cnn->prepare($sql);
	$majServeur->execute();
	
	$sql = 'update variable set value ="'.$mdp.'" where nomVariable = "Password";';
	$majServeur = $Cnn->prepare($sql);
	$majServeur->execute();
	
	$sql = 'update variable set value ="'.$host.'" where nomVariable = "Host";';
	$majServeur = $Cnn->prepare($sql);
	$majServeur->execute();
	
	$sql = 'update variable set value ="'.$port.'" where nomVariable = "Port";';
	$majServeur = $Cnn->prepare($sql);
	$majServeur->execute();
	
	$sql = 'update variable set value ="'.$utilisateur.'" where nomVariable = "Username";';
	$majServeur = $Cnn->prepare($sql);
	$majServeur->execute();
	$_SESSION['temps'] = 'Modification de variables serveurs effectuée';
	unset($_SESSION['email']);
	unset($_SESSION['mdp']);
	unset($_SESSION['gestionnaire']);
	
	header('location:index.php');
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>