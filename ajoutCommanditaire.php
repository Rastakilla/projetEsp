<?php
session_start();
include('connexionBd.php');
   if(isset($_FILES['image']) && isset($_POST['commanditaire']))
   {
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors="Image JPG, JPEG ou PNG seulement.";
      }
	        
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"img/com/".$file_name);
	
		$sql = 'insert into commanditaire (nomCommanditaire,pathCommanditaire) VALUES ("'.$_POST['commanditaire'].'","'.$file_name.'");';
		$mettreCommanditaire = $Cnn->prepare($sql);
		$mettreCommanditaire->execute();
		$_SESSION['Uploader'] = 'True';	
		
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
		 
      }else{
       	$_SESSION['Uploader'] =$errors;	
		$uniqId = uniqid();
		$ajoutUniqId = $Cnn->prepare('update gestionnaire set uniqId = "'.$uniqId.'" where email = "'.$_GET['email'].'" ');
		$ajoutUniqId->execute();
		header('location:Gestionnaire.php?id='.$uniqId.'&email='.$_GET['email']);
      }
   }
?>