<?php
session_start();
include('connexionBd.php');
   if(isset($_POST['sprmCom']) && isset($_SESSION['email'])){
	   $sql = 'select pathCommanditaire from commanditaire where nomCommanditaire = "'.$_POST["sprmCom"].'";';
	   $infoCommanditaire = $Cnn->prepare($sql);
	   $infoCommanditaire->execute();
	   if ($pathCommanditaire = $infoCommanditaire->fetch())
	   {
		   		unlink('img/com/'.$pathCommanditaire["pathCommanditaire"]);
	   }
		$sql = 'delete from commanditaire where nomCommanditaire="'.$_POST["sprmCom"].'";';
		$mettreCommanditaire = $Cnn->prepare($sql);
		$mettreCommanditaire->execute();
		$_SESSION['Uploader'] = 'Suppression de commanditaire effectuée';	
		
		header('location:Gestionnaire.php');
		 
      }else{
		  $_SESSION['acces'] = 'non';
		header('location:index.php');
      }
?>