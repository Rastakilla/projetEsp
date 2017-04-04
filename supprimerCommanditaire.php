<?php
session_start();
include('connexionBd.php');
   if(isset($_POST['sprmCom'])){
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
		$_SESSION['Uploader'] = 'True';	
		
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
		 
      }else{
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
      }
?>