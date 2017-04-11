<?php
session_start();
include('connexionBd.php');
   if(isset($_POST['sprmEmail'])){

		$sql = 'delete from gestionnaire where email="'.$_POST["sprmEmail"].'";';
		$sprmGestionnaire = $Cnn->prepare($sql);
		$sprmGestionnaire->execute();
		$_SESSION['Uploader'] = 'Suppression du gestionnaire effectuée';	
		
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