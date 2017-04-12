<?php
session_start();
include('connexionBd.php');
   if(isset($_POST['sprmEmail']) && isset($_SESSION['email'])){

		$sql = 'delete from gestionnaire where email="'.$_POST["sprmEmail"].'";';
		$sprmGestionnaire = $Cnn->prepare($sql);
		$sprmGestionnaire->execute();
		$_SESSION['Uploader'] = 'Suppression du gestionnaire effectuée';	
		
		header('location:Gestionnaire.php');
		 
      }else{
		  $_SESSION['acces'] = 'non';
		header('location:index.php');
      }
?>