<?php
session_start();
include('connexionBd.php');
   if(isset($_FILES['image'])){
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
         move_uploaded_file($file_tmp,"img/categorie/".$file_name);
		 
		 $trouverCategorie = $Cnn->prepare('select idCategorie from categorie where nomCategorie = :nomcategorie');
		 $trouverCategorie->execute(array('nomcategorie' => $_POST['categorie']));
		 if ($categorie = $trouverCategorie->fetch())
		 {
			 $idCategorie = $categorie['idCategorie'];
		 }
		 $trouverEtat = $Cnn->prepare('select idetat from etat where NomEtat = :nometat');
		 $trouverEtat->execute(array('nometat' => $_POST['etat']));
		 if ($etat = $trouverEtat->fetch())
		 {
			 $idEtat = $etat['idetat'];
		 }
		 
		 
		 
		 $ajoutOeuvre = $Cnn->prepare("insert into oeuvres (nomOeuvre,Auteur,Dimension,Titre,Annee,idCategorie,idEtat,lieu) VALUES ('".$file_name."','".$_POST['auteur']."','".$_POST['dimensions']."','".$_POST['titre']."','".$_POST['annee']."','".$idCategorie."','".$idEtat."','".$_POST['lieu']."')");
		$ajoutOeuvre->execute();	
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