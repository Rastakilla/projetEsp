<?PHP
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?PHP
  include('connexionBd.php');
  ?>
  <style>
  label.error{
	color: red;
}
</style>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galerie des Arts Visuels</title>
    <!-- Favicons
    ================================================== -->
   <link rel="icon" href="favicon.ico" />
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

    <!-- Slider
    ================================================== -->
    <link href="css/owl.carousel.css" rel="stylesheet" media="screen">
    <link href="css/owl.theme.css" rel="stylesheet" media="screen">

    <!-- Stylesheet
    ================================================== -->
    <link rel="stylesheet" type="text/css"  href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link href="lightbox2-master/dist/css/lightbox.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="js/modernizr.custom.js"></script>
       <script src="js/jssor.slider-22.2.16.min.js" type="text/javascript"></script>
       <script src="lightbox2-master/dist/js/lightbox.js"></script>
       <script src="lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>
       
  </head>
  <body style='height:92.3vh;'>
	<?PHP include('includes/HeaderGestionnaire.php'); ?>

    <!-- Oeuvres
    ==========================================-->
    <div id="tf-verif" class="text-center">
        <div class="overlay">
            <div class="content" style='top:-150px;' >
            <?PHP
            if (isset($_SESSION['email']) && htmlentities($_SESSION['email']) && isset($_SESSION['mdp']) && htmlentities($_SESSION['mdp']))
			{
					if (isset($_SESSION['Uploader']) && $_SESSION['Uploader'] != '' && $_SESSION['Uploader'] !=NULL)
					{
						 echo '<script>alert("'.$_SESSION['Uploader'].'");</script>';
						 unset($_SESSION['Uploader']);
					}
				
				
				$email = htmlentities($_SESSION['email']);
				$mdp = htmlentities($_SESSION['mdp']);
				$verificateur = false;
				$reponseGestionnaire = $Cnn->prepare('SELECT email from gestionnaire where email = "'.$email.'" and mdp = "'.$mdp.'";');
				$reponseGestionnaire->execute();
				if($reponseGestionnaire->fetch() == true)
				{
					$verificateur = true;
				}
				if ($verificateur == false)
				{
					header('Location : index.php');
					$_SESSION['acces'] = 'non';
				}
				else
				{
						$reponseEtat = $Cnn->prepare('SELECT NomEtat,idetat from etat;');
						$reponseEtat->execute();
						$reponseCategorie = $Cnn->prepare('SELECT nomCategorie,idCategorie from categorie;');
						$reponseCategorie->execute();
						?>
						 <div>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="oeuvre();">Oeuvre</button>&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="etat();">État</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="categorie();">Médium</button>&nbsp;&nbsp;&nbsp;					
                    <button type="button" class="btn tf-btn btn-notdefault" onclick="reservation();">Réservation</button>&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="gestionnaire();">Gestionnaire</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="commanditaire();">Commanditaire</button>&nbsp;&nbsp;&nbsp;

					</div>
						
						
						
					<div id="divCom" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="ajouterCommanditaire();">Ajouter Commanditaire</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="sprmCommanditaire();">Supprimer Commanditaire</button>&nbsp;&nbsp;&nbsp;
					 </div>
					  				
					  <div id="divGes" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="ajouterGestionnaire();">Ajouter Gestionnaire</button>&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="sprmGestionnaire();">Supprimer Gestionnaire</button>&nbsp;&nbsp;&nbsp;
					 </div>
					 
					 <div id="divOv" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="ajouterOeuvre();">Ajouter Oeuvre</button>&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="afficherTitre();">Modifier Oeuvre</button>&nbsp;&nbsp;&nbsp;
					  </div>
					  
					  <div id="divEtat" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="ajouterEtat();">Ajouter État</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="afficherEtat();">Modifier État</button>&nbsp;&nbsp;&nbsp;
					</div>
					 
					<div id="divCat" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="ajouterCategorie();">Ajouter Médium</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="afficherMedium();">Modifier Médium</button>&nbsp;&nbsp;&nbsp;
					</div>
                    
                    	<div id="divRes" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="voirReservation();">Voir Réservations</button>&nbsp;&nbsp;&nbsp;
					</div>
                    <style>
                    table, th, td {
						border: 1px solid white;
						border-collapse: collapse;
					}
					</style>
					<?PHP
					
					 /**********************************/	
					/*DEBUT FORM POUR VOIR RESERVATION*/
				   /**********************************/
				   		$reponseReservation = $Cnn->prepare('Select * from reservation order by date;');
						$reponseReservation->execute();
				   
				echo '  <form id="formReservation" style="display:none;" enctype="multipart/form-data">';
				echo ' <div> <br>
						<table style="width:95%; margin-left:5%;">
						  <tr>
						  	<th>Oeuvre</th>
							<th>Nom</th> 
							<th>Prenom</th>
							<th>Mail</th>
							<th>Local</th>
							<th>Date</th>
							<th>Supprimer</th>
						  </tr>';
						  $path = '';
						  $titre = '';
						while ($infoReservation = $reponseReservation->fetch())
						{
							$reponseOeuvre = $Cnn->prepare('Select Titre,nomOeuvre from oeuvres where idOeuvres = '.$infoReservation["idOeuvre"].';');
							$reponseOeuvre->execute();
							if ($oeuvre = $reponseOeuvre->fetch())
							{
								$path = $oeuvre["nomOeuvre"];
								$titre = $oeuvre["Titre"];
							}
						echo ' <tr>
						  	<th>'.$titre.'</th>
							<th>'.$infoReservation["NomPersonneReserve"].'</th>
							<th>'.$infoReservation["PrenomPersonneReserve"].'</th>
							<th>'.$infoReservation["MailPersonneReserve"].'</th>
							<th>'.$infoReservation["Local"].'</th>
							<th>'.$infoReservation["Date"].'</th>
							 <th><img src=img/trash.png style="width:30%; cursor:pointer;" onClick="supprimer('.$infoReservation["idReservation"].','.$infoReservation["idOeuvre"].')"></th>
						  </tr>';
						} 
					 
                    echo '</table></div></form>';//fermeture form
				   	 /*********************************/	
					/*FIN  FORM POUR VOIR RESERVATION*/
				   /*********************************/
					
					
					
					
					 /****************************************/	
					/*DEBUT FORM DE L'AJOUT DE COMMANDITAIRE*/
				   /****************************************/
					echo '<form id="formAjoutCommanditaire" style="display:none;" action="ajoutCommanditaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
				 echo ' <div> <br><label>Nom du commanditaire</label>
                       <input class="form-control" id="commanditaire" name="commanditaire" placeholder="Entrez le nom du commanditaire"></input></div>';//nomCommanditaire
                     echo '<div><br><label for="image">Image</label>
                     <input type="file" name="image" id="image"></div>';//imageCommanditaire
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /**************************************/	
					/*FIN FORM DE L'AJOUT DE COMMANDITAIRE*/
				   /**************************************/
				     /***************************************/	
					/*DEBUT FORM DE DELETE DE COMMANDITAIRE*/
				   /***************************************/
				$reponseCommanditaire = $Cnn->prepare('Select nomCommanditaire,idCommanditaire from commanditaire;');
						$reponseCommanditaire->execute();
					echo '<form id="formSprmCommanditaire" style="display:none;" action="supprimerCommanditaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
									 echo ' <div> <label>Nom du commanditaire</label>
                                    <select class="form-control" id="sprmCom" name="sprmCom">';
									echo '<option id="sprmCom0"></option>';
									while($infoCommanditaire = $reponseCommanditaire->fetch())
									{
										echo '<option id="com'.$infoCommanditaire['idCommanditaire'].'">'.$infoCommanditaire['nomCommanditaire'].'</option>';
									}
									echo'</select></div><br>';//com
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Supprimer</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /*************************************/	
					/*FIN FORM DE DELETE DE COMMANDITAIRE*/
				   /*************************************/
					
					 /***************************************/	
					/*DEBUT FORM DE L'AJOUT DE GESTIONNAIRE*/
				   /***************************************/
					echo '<form id="formGestionnaire" style="display:none;" action="ajoutGestionnaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>Email</label>
                                    <input class="form-control" id="mail" name="mail" placeholder="Entrez le email du gestionnaire"></input><br></div>';//email
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /*************************************/	
					/*FIN FORM DE L'AJOUT DE GESTIONNAIRE*/
				   /*************************************/
				   
				   
				   	/*************************************/	
					/*DEBUT FORM DE SPRM DE GESTIONNAIRE*/
				   /************************************/
					echo '<form id="formGestionnaire" style="display:none;" action="ajoutGestionnaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>Email</label>
                                    <input class="form-control" id="mail" name="mail" placeholder="Entrez le email du gestionnaire"></input><br></div>';//email
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /**********************************/	
					/*FIN FORM DE SPRM DE GESTIONNAIRE*/
				   /**********************************/
				   $sql = 'select * from gestionnaire';
				   $reponseSprmGestionnaire = $Cnn->prepare($sql);
				   $reponseSprmGestionnaire->execute();
				   
				   					echo '<form id="formSprmGestionnaire" style="display:none;" action="sprmGestionnaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
					
							echo ' <div> <label>Email</label>
                                    <select class="form-control" id="sprmEmail" name="sprmEmail">';
					echo '<option id="sprmEmail0"></option>';
						while($infoSprmGestionnaire = $reponseSprmGestionnaire->fetch())
						{
							echo '<option id="etat'.$infoSprmGestionnaire['idgestionnaire'].'">'.$infoSprmGestionnaire['email'].'</option>';
						}
						
						echo '</select><br></div>';//etat
						
						echo' <div><button type="submit" class="btn tf-btn btn-default">Supprimer</button></div>';//button
						
						  echo' </form>';//fermeture form
					
					/*********************************/	
					/*DEBUT FORM DE L'AJOUT D'OEUVRES*/
					/*********************************/
					echo '<form id="formAjouterOeuvre" style="display:none;"  action="ajoutOeuvre.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>Auteur</label>
                                    <input class="form-control" id="auteur" name="auteur" placeholder="Entrez le nom de l\'auteur"></input></div>';//auteur
					 echo ' <div> <label>Titre</label>
                                    <input class="form-control" id="titre" name="titre" placeholder="Entrez le titre"></input></div>';//titre
					echo ' <div> <label>Hauteur</label>
                                    <input class="form-control" id="hauteur" name="hauteur" placeholder="Entrez la hauteur en centimètre"></input></div>';//Hauteur
					echo ' <div> <label>Largeur</label>
                                    <input class="form-control" id="largeur" name="largeur" placeholder="Entrez la hauteur en centimètre"></input></div>';//Largeur
					echo ' <div> <label>Profondeur</label>
                                    <input class="form-control" id="profondeur" name="profondeur" placeholder="Entrez la profondeur en centimètre"></input></div>';//Profondeur
					echo ' <div> <label>Emplacement</label>
                                    <input class="form-control" id="lieu" name="lieu" placeholder="Entrez l\'emplacement(si applicable, local ou endroit)"></input></div>';//lieu ou emplacement
				echo ' <div> <label>Description</label>
                                    <input class="form-control" id="description" name="description" placeholder="Entrez un description (facultatif)"></input></div>';//description		
					 echo ' <div> <label>Année</label>
                                    <select class="form-control" id="annee" name="annee">';
									echo '<option id="annee0"></option>';
									$cpt =  date("Y");
									$cpt2 =  date("Y")-100;
									while ($cpt >= $cpt2)
									{
										echo '<option id="annee'.$cpt.'">'.$cpt.'</option>';
										$cpt--;										
									}
									echo'</select></div>';//annee							
									
					echo ' <div> <label>Médium</label>
                                    <select class="form-control" id="categorie" name="categorie">';
					echo '<option id="categorie0"></option>';
						while($infoCategorie = $reponseCategorie->fetch())
						{
							echo '<option id="categorie'.$infoCategorie['idCategorie'].'">'.$infoCategorie['nomCategorie'].'</option>';
						}
									
						echo'</select></div>';//Categorie
				
					echo ' <div> <label>État</label>
                                    <select class="form-control" id="etat" name="etat">';
					echo '<option id="etat0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="etat'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						
						echo '</select><br></div>';//etat
						
						
						 echo '<div><label for="image">Image</label>
                     <input type="file" name="image" id="image"></div>';//fichier		
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /*******************************/	
					/*FIN FORM DE L'AJOUT D'OEUVRES*/
				   /*******************************/
				   
				   	 /*****************************/	
					/*DEBUT FORM MODIFIER OEUVRES*/
				   /*****************************/
				   $reponseEtat = $Cnn->prepare('SELECT NomEtat,idetat from etat;');
					$reponseEtat->execute();
					$reponseCategorie = $Cnn->prepare('SELECT nomCategorie,idCategorie from categorie;');
					$reponseCategorie->execute();
				   $titresOeuvre = $Cnn->prepare('Select Titre from oeuvres;');
				   $titresOeuvre->execute();
				   echo '<form id="formAllTitre"  style="display:none;">';
				   echo '<br><div> <label>Tous les Titres d\'oeuvres</label>';
				   echo' <select class="form-control" id="allTitre" name="allTitre" onchange="ajaxModifierOeuvre();">';
				   echo '<option id="noTitre"></option>';
				   while ($titreOeuvre = $titresOeuvre->fetch())
				   {
							echo '<option id="'.$titreOeuvre['Titre'].'" value = "'.$titreOeuvre['Titre'].'">'.$titreOeuvre['Titre'].'</option>';									
					}
					echo'</select></div>';//Tous les Titres	
					echo '</form>';
					echo '<form id="formModifierOeuvre" style="display:none;"  action="modifierOeuvre.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
					echo "<br> <a id ='oeuvreImage' data-lightbox='Oeuvre'><p class = 'color'><b><u>VOIR L'OEUVRE</u></b></p></a>";
                    echo ' <div> <label>Auteur</label>
                                    <input class="form-control" id="auteurM" name="auteurM" placeholder="Entrez le nom de l\'auteur"></input></div>';//auteur
					 echo ' <div> <label>Titre</label>
                                    <input class="form-control" id="titreM" name="titreM" placeholder="Entrez le titre"></input></div>';//titre
					echo ' <div> <label>Hauteur</label>
                                    <input class="form-control" id="hauteurM" name="hauteurM" placeholder="Entrez la hauteur en centimètre"></input></div>';//Hauteur
					echo ' <div> <label>Largeur</label>
                                    <input class="form-control" id="largeurM" name="largeurM" placeholder="Entrez la hauteur en centimètre"></input></div>';//Largeur
					echo ' <div> <label>Profondeur</label>
                                    <input class="form-control" id="profondeurM" name="profondeurM" placeholder="Entrez la profondeur en centimètre"></input></div>';//Profondeur
					echo ' <div> <label>Emplacement</label>
                                    <input class="form-control" id="lieuM" name="lieuM" placeholder="Entrez l\'emplacement(si applicable, local ou endroit)"></input></div>';//lieu ou emplacement
				echo ' <div> <label>Description</label>
                                    <input class="form-control" id="descriptionM" name="descriptionM" placeholder="Entrez un description (facultatif)"></input></div>';//description		
					 echo ' <div> <label>Année</label>
                                    <select class="form-control" id="anneeM" name="anneeM">';
									echo '<option id="anneeM0"></option>';
									$cpt = date("Y");
									$cpt2 = date("Y") - 100;
									while ($cpt >=$cpt2)
									{
										echo '<option id="anneeM'.$cpt.'">'.$cpt.'</option>';
										$cpt--;										
									}
									echo'</select></div>';//annee							
									
					echo ' <div> <label>Catégorie</label>
                                    <select class="form-control" id="categorieM" name="categorieM">';
					echo '<option id="categorieM0"></option>';
						while($infoCategorie = $reponseCategorie->fetch())
						{
							echo '<option id="categorieM'.$infoCategorie['idCategorie'].'">'.$infoCategorie['nomCategorie'].'</option>';
						}
									
						echo'</select></div>';//Categorie
				
					echo ' <div> <label>État</label>
                                    <select class="form-control" id="etatM" name="etatM">';
					echo '<option id="etatM0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="etatM'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						
						echo '</select><br></div>';//etat	
					echo '<input type="hidden" id="idOeuvre" name="idOeuvre">';
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Modifier</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /***************************/	
					/*FIN FORM MODIFIER OEUVRES*/
				   /***************************/
				   
				   	   
				   
				  	 /******************************/	
					/*DEBUT FORM DE L'AJOUT D'ÉTAT*/
				   /******************************/
					echo '<form id="formEtat" style="display:none;"  action="ajoutEtat.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>État</label>
                                    <input class="form-control" id="etat" name="etat" placeholder="Entrez l\'état"></input><br></div>';//etat
									
				 echo ' <div> <label>Réservation</label> <b><i>Indiquez si cette état permet la réservation.</i></b> <select class="form-control" id="reservation" name="reservation"><br></div>';
					 echo '<option id="blind"></option>';
						echo '<option id="0">Ne peux être reservée ou empruntée</option>';
						echo '<option id="1">Peux être empruntée</option>';
						echo '<option id="2">Peux être reservée</option>';
				 echo '</select><br></div>';//reservation
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /****************************/	
					/*FIN FORM DE L'AJOUT D'ÉTAT*/
				   /****************************/
				   
				   
				   	 /****************************/	
					/*DEBUT FORM DE MODIF D'ÉTAT*/
				   /****************************/
				   
				   
				   	$reponseEtat = $Cnn->prepare('SELECT NomEtat,idetat from etat;');
					$reponseEtat->execute();
					echo '<form id="formAllEtat" style="display:none;" method="POST" enctype="multipart/form-data">';
                   	echo ' <div> <label>Tous les états</label>
                                    <select class="form-control" id="AllEtat" name="AllEtat" onchange="ajaxModifierEtat();">';
					echo '<option id="allEtat0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="allEtat'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						
						echo '</select><br></div>';//etat	
									
                   echo' </form>';//fermeture form
				  
				  
				   echo '<form id="formModifierEtat" style="display:none;"  action="modifierEtat.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
				   	echo ' <div> <label>État</label>
					<input class="form-control" id="EtatModif" name="EtatModif" placeholder="Entrez l\'état"></input></div>';//Etat
				   	 echo ' <div> <label>Réservation</label> <b><i>Indiquez si cette état permet la réservation.</i></b> <select class="form-control" id="reservationModif" name="reservationModif"><br></div>';
						echo '<option id="0">Ne peux être reservée ou empruntée</option>';
						echo '<option id="1">Peux être empruntée</option>';
						echo '<option id="2">Peux être reservée</option>';
				 echo '</select><br></div>';//reservation
				 					echo '<input type="hidden" id="idEtat" name="idEtat">';
				                    echo' <div><button type="submit" class="btn tf-btn btn-default">Modifier</button></div>';//button
				    echo' </form>';//fermeture form
				   	 /**************************/	
					/*FIN FORM DE MODIF D'ÉTAT*/
				   /**************************/
				   
				   
				   	 /************************************/	
					/*DEBUT FORM DE L'AJOUT DE CATÉGORIE*/
				   /************************************/
					echo '<form id="formCategorie" style="display:none;"  action="ajoutCategorie.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>Médium</label>
                                    <input class="form-control" id="medium" name="medium" placeholder="Entrez le médium"></input><br></div>';//categorie
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /**********************************/	
					/*FIN FORM DE L'AJOUT DE CATÉGORIE*/
				   /**********************************/
				   
				   	 /**********************************/	
					/*DEBUT FORM DE MODIF DE CATÉGORIE*/
				   /**********************************/
				   
				   
				   	$reponseMedium = $Cnn->prepare('SELECT * from categorie;');
					$reponseMedium->execute();
					echo '<form id="formAllMedium" style="display:none;" method="POST" enctype="multipart/form-data">';
                   	echo ' <div> <label>Tous les Médiums</label>
                                    <select class="form-control" id="AllMedium" name="AllMedium" onchange="ajaxModifierMedium();">';
					echo '<option id="allMedium0"></option>';
						while($infoMedium = $reponseMedium->fetch())
						{
							echo '<option id="allEtat'.$infoMedium['idCategorie'].'">'.$infoMedium['nomCategorie'].'</option>';
						}
						
						echo '</select><br></div>';//etat	
									
                   echo' </form>';//fermeture form
				   
					echo '<form id="formModifierMedium" style="display:none;"  action="modifierMedium.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>Médium</label>
                                    <input class="form-control" id="mediumModif" name="mediumModif" placeholder="Entrez le médium"></input><br></div>';//categorie
				echo '<input type="hidden" id="idMedium" name="idMedium">';			
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Modifier</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /********************************/	
					/*FIN FORM DE MODIF DE CATÉGORIE*/
				   /********************************/
				}
			}
			?>               
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.1.11.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/SmoothScroll.js"></script>
    <script type="text/javascript" src="js/jquery.isotope.js"></script>
    <script src="js/owl.carousel.js"></script>
    

    <!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="jquery-validation-1.15.0/lib/jquery-1.11.1.js"></script>
<script type="text/javascript" src="jquery-validation-1.15.0/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="jquery-validation-1.15.0/dist/localization/messages_fr.js"></script>
    <script>
$("#formGestionnaire").validate(
	{	rules:
		{	mail: {	required:true,	
						regex_E:true
					}
		},
		messages : { 			mail : {required : 'Le email est obligatoire',
										regex_E :'Doit etre de format @cegepba.qc.ca',
								}
					}
					
	}
);
$.validator.addMethod("regex_E", 
		function (value, element){
				return this.optional(element) || /^[a-zA-Z]+@cegepba\.qc\.ca$/.test(value);
			});
$("#formAjouterOeuvre").validate(
	{	rules:
		{	auteur: {	required:true,			
					},
			hauteur: {	required:true,	
						regex_N:true,		
					},
			largeur: {	required:true,
						regex_N:true,			
					},
			profondeur:{ regex_N:true,
					},
			titre: {	required:true,			
					},			
			annee: {	required:true,			
					},
			categorie: {	required:true,			
					},
			etat: {	required:true,			
					},
			image:{	required:true,			
					}
		},
		messages : { 			auteur : {required : 'L\'auteur est obligatoire'},
								hauteur : {required : 'La hauteur est obligatoire',
											regex_N: ' Doit être un nombre. Utiliser le point au lieu de la virgule'},
								largeur : {required : 'La largeur est obligatoire',
											regex_N: ' Doit être un nombre. Utiliser le point au lieu de la virgule'},
								profondeur : {regex_N: ' Doit être un nombre. Utiliser le point au lieu de la virgule'},
								titre : {required : 'Le titre est obligatoire'},
								annee : {required : 'L\'année est obligatoire'},
								categorie : {required : 'La categorie est obligatoire'},
								etat : {required : 'L\'etat est obligatoire'},
								image : {required : 'L\'image est obligatoire'}
					}
	}
);
$("#formModifierOeuvre").validate(
	{	rules:
		{	auteurM: {	required:true,			
					},
			hauteurM: {	required:true,	
						regex_N:true,		
					},
			largeurM: {	required:true,
						regex_N:true,			
					},
			profondeurM:{ regex_N:true,
					},
			titreM: {	required:true,			
					},			
			anneeM:{	required:true,			
					},
			categorieM: {	required:true,			
					},
			etatM: {	required:true,			
					}
		},
		messages : { 			auteurM : {required : 'L\'auteur est obligatoire'},
								hauteurM : {required : 'La hauteur est obligatoire',
											regex_N: ' Doit être un nombre. Utiliser le point au lieu de la virgule'},
								largeurM : {required : 'La largeur est obligatoire',
											regex_N: ' Doit être un nombre. Utiliser le point au lieu de la virgule'},
								profondeurM : {regex_N: ' Doit être un nombre. Utiliser le point au lieu de la virgule'},
								titreM : {required : 'Le titre est obligatoire'},
								anneeM : {required : 'L\'année est obligatoire'},
								categorieM : {required : 'La categorie est obligatoire'},
								etatM : {required : 'L\'etat est obligatoire'}
					}
	}
);
$.validator.addMethod("regex_N", 
		function (value, element){
				return this.optional(element) || /^(?:[1-9]\d*|0)?(?:\.\d+)?$$/.test(value);
});
$("#formEtat").validate(
	{	rules:
		{	etat: {	required:true
					},
			reservation:{	required:true
					}
		},
		messages : { 			etat : {required : 'L\'état est obligatoire'},
								reservation : {required : 'La possibilité de réservation est obligatoire'}
					}
					
	}
);
$("#formCategorie").validate(
	{	rules:
		{	categorie: {	required:true
					}
		},
		messages : { 			categorie : {required : 'La catégorie est obligatoire'}
					}
					
	}
);
$("#formAjoutCommanditaire").validate(
	{	rules:
		{	commanditaire: {	required:true
					},
			image: {	required:true
					}
		},
		messages : { 			commanditaire : {required : 'Le nom du commanditaire est obligatoire'},
								image:  {required : 'L\'image du commanditaire est obligatoire'}
					}
					
	}
);
$("#formSprmCommanditaire").validate(
	{	rules:
		{	commanditaire: {	required:true
					}
		},
		messages : { 			commanditaire : {required : 'Le nom du commanditaire est obligatoire'},
					}
					
	}
);

	function commanditaire() {
			$('#divCom').slideToggle("slow", function () {
			});
			$('#divGes').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formGestionnaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#divRes').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}	
		function reservation() {
			$('#divRes').slideToggle("slow", function () {
			});
			$('#divCom').css('display', 'none');
			$('#divGes').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formGestionnaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
		    $('#formSprmCommanditaire').css('display', 'none');
		}	
		function gestionnaire() {
			$('#divGes').slideToggle("slow", function () {
			});
			$('#divCom').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formAjoutCommanditaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#divRes').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
			function oeuvre() {
			$('#divOv').slideToggle("slow", function () {
			});
			$('#divGes').css('display', 'none');
			 $('#divCom').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formAjoutCommanditaire').css('display', 'none');
			 $('#formGestionnaire').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			  $('#formAllTitre').css('display', 'none');
			  $('#formSprmCommanditaire').css('display', 'none');
			  $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#divRes').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function etat() {
			$('#divEtat').slideToggle("slow", function () {
			});
			$('#divGes').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divCom').css('display', 'none');
			 $('#divCat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formCategorie').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#divRes').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function categorie() {
			$('#divCat').slideToggle("slow", function () {
			});
			$('#divGes').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCom').css('display', 'none');
			 $('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			$('#formSprmGestionnaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#divRes').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}
		
	function ajouterCommanditaire() {
			$('#formAjoutCommanditaire').slideToggle("slow", function () {
			});
			$('#formGestionnaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
		     $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function ajouterGestionnaire() {
			$('#formGestionnaire').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function ajouterOeuvre() {
			$('#formAjouterOeuvre').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formGestionnaire').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function afficherTitre() {
			$('#formAllTitre').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formGestionnaire').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			  $('#formAjouterOeuvre').css('display', 'none');
			  $('#formModifierOeuvre').css('display', 'none');
			  $('#formSprmCommanditaire').css('display', 'none');
			  $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function modifierOeuvre() {
			$('#formModifierOeuvre').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formGestionnaire').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			  $('#formAjouterOeuvre').css('display', 'none');
			  $('#formAllTitre').css('display', 'none');
			  $('#formSprmCommanditaire').css('display', 'none');
			  $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function ajouterEtat() {
			$('#formEtat').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formCategorie').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function ajouterCategorie() {
			$('#formCategorie').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function sprmCommanditaire(){
				$('#formSprmCommanditaire').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formSprmGestionnaire').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
		}
		function modifierEtat(){
				$('#formModifierEtat').slideToggle("slow", function () {
			});
			$('#formModifierMedium').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formSprmGestionnaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}
		function afficherEtat(){
				$('#formAllEtat').slideToggle("slow", function () {
			});
			$('#formModifierEtat').css('display', 'none');
			$('#formModifierMedium').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formSprmGestionnaire').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}
		function modifierMedium(){
				$('#formModifierMedium').slideToggle("slow", function () {
			});
			$('#formCategorie').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formSprmGestionnaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}
		
		function afficherMedium(){
				$('#formAllMedium').slideToggle("slow", function () {
			});
			$('#formCategorie').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formSprmGestionnaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formModifierMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}
			function sprmGestionnaire(){
				$('#formSprmGestionnaire').slideToggle("slow", function () {
			});
			$('#formModifierMedium').css('display', 'none')
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
		}
		
		function voirReservation(){
				$('#formReservation').slideToggle("slow", function () {
			});
			$('#formModifierMedium').css('display', 'none')
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formGestionnaire').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formSprmGestionnaire').css('display', 'none');
		}
	function ajaxModifierOeuvre()
	{ 
		var e = document.getElementById('allTitre');
		var selectedIndex = e.options[e.selectedIndex].value;
    	$.ajax({
				url: "chercherInfosOeuvres.php", 
				type: 'POST',
				dataType: 'html',
				data:{selectedIndex:selectedIndex},
				success : function(output)
		           {
					   var infos = JSON.parse(output);
					   document.getElementById('auteurM').value = infos.Auteur;
					   document.getElementById('titreM').value = infos.Titre;
					   document.getElementById('hauteurM').value = infos.Hauteur;
					   document.getElementById('largeurM').value = infos.Largeur;
					   document.getElementById('profondeurM').value = infos.Profondeur;
					   document.getElementById('lieuM').value = infos.lieu;
					   document.getElementById('descriptionM').value = infos.description;
					   document.getElementById('anneeM').value = infos.Annee;
					   document.getElementById('categorieM').value = infos.nomCategorie;
					   document.getElementById('etatM').value = infos.NomEtat;
					   document.getElementById('idOeuvre').value = infos.idOeuvres;
					   document.getElementById('oeuvreImage').href = 'img/categorie/'+infos.nomOeuvre;
					   modifierOeuvre();
			       }
				});
};


function ajaxModifierEtat()
{ 
	var e = document.getElementById('AllEtat');
	var selectedIndex = e.options[e.selectedIndex].value;
	$.ajax({
			url: "chercherInfosEtats.php", 
			type: 'POST',
			dataType: 'html',
			data:{selectedIndex:selectedIndex},
			success : function(output)
			   {
				   var infos = JSON.parse(output);
				   document.getElementById('EtatModif').value = infos.nomEtat;
				   document.getElementById('reservationModif').selectedIndex = infos.peuxEtreReserve;
				   document.getElementById('idEtat').value = infos.idetat;
				   modifierEtat();
			   }
			});
};
function ajaxModifierMedium()
{ 
	var e = document.getElementById('AllMedium');
	var selectedIndex = e.options[e.selectedIndex].value;
	$.ajax({
			url: "chercherInfosMediums.php", 
			type: 'POST',
			dataType: 'html',
			data:{selectedIndex:selectedIndex},
			success : function(output)
			   {
				   var infos = JSON.parse(output);
				   document.getElementById('mediumModif').value = infos.nomCategorie;
				   document.getElementById('idMedium').value = infos.idCategorie;
				   modifierMedium();
			   }
			});
};
function supprimer(idReservation,idOeuvre)
{
	 $.ajax({
		  url : "Supprimer.php",
		  type : 'POST',
		  dataType:'html',
		  data : {idReservation:idReservation,idOeuvre:idOeuvre},
		  success: function(output)
		  			{
						alert("Supression effectuée");
						document.location.href="Gestionnaire.php";
						$('#divRes').css('display', 'block');
						voirReservation();
					},
		});
}
</script>

  </body>
                    	<?PHP include('includes/Footer.php'); ?>
</html>