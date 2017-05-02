<?PHP
session_start();
unset($_SESSION['gestionnaire']);
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
.dataTables_filter label {  
color:#FFF;
}
.dataTables_filter input {  
color:black;
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
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
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
    
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

    <script type="text/javascript" src="js/modernizr.custom.js"></script>
       <script src="js/jssor.slider-22.2.16.min.js" type="text/javascript"></script>
       <script src="lightbox2-master/dist/js/lightbox.js"></script>
       <script src="lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>
       
  </head>
  <body  style="height:92.3vh; min-height:100%; background-color:#2E3033;" onload ="menu();">
	<?PHP include('includes/HeaderGestionnaire.php'); ?>

    <!-- Oeuvres
    ==========================================-->
    <div id="tf-verif" class="text-center">
        <div class="overlay">
            <div class="content" style='top:-150px;' >
            <?PHP
			$sql = 'select idReservation,Date from reservation';
			$delReservation = $Cnn->prepare($sql);
			$delReservation->execute();
			while ($Reservation = $delReservation->fetch())
			{
				$DateNow = date('Y-m-d H:i:s');
				$date1Timestamp = strtotime($Reservation['Date']);
				$date2Timestamp = strtotime($DateNow);
				$difference = $date2Timestamp - $date1Timestamp;
				$difference = $difference/(60*60*24);
				if ($difference >= 1)
				{
					$sql2 = 'delete from reservation where idReservation = '.$Reservation['idReservation'];
					$del = $Cnn->prepare($sql2);
					$del->execute();
				}
			}
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
					$_SESSION['acces'] = 'non';
					header('Location : index.php');
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
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="emprunt();">Emprunt</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="commanditaire();">Commanditaire</button>&nbsp;&nbsp;&nbsp;

					</div>
						
						
						
					<div id="divCom" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="ajouterCommanditaire();">Ajouter Commanditaire</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="sprmCommanditaire();">Supprimer Commanditaire</button>&nbsp;&nbsp;&nbsp;
					 </div>
					  				
					  <div id="divEmprunt" style="display:none"><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="voirEmprunt();">Voir Emprunts</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn tf-btn btn-notdefault" onclick="voirDeplacementsFin();">Déplacements de fin d'année</button>&nbsp;&nbsp;&nbsp;
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
                    <button type="button" class="btn tf-btn btn-notdefault" onclick="voirDeplacementsAnnee();">Déplacements en cours d'année</button>&nbsp;&nbsp;&nbsp;
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
				   		$reponseReservation = $Cnn->prepare('Select * from reservation where effectif = 1 order by date;');
						$reponseReservation->execute();
				  ?> 
				<form id="formReservation" style="display:none;" enctype="multipart/form-data">
				<div align="center"> <br>
						<table style="width:95%; margin-left:5%;">
						  <tr>
						  	<th>Oeuvre</th>
							<th>Nom</th> 
							<th>Prenom</th>
							<th>Mail</th>
							<th>Local</th>
							<th>Date</th>
							<th>Supprimer</th>
						  </tr>
                          <?PHP
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
						  	<th><a href="img/categorie/'.$path.'" data-lightbox="'.$path.'"><u>'.$titre.'</u></a></th>
							<th>'.$infoReservation["NomPersonneReserve"].'</th>
							<th>'.$infoReservation["PrenomPersonneReserve"].'</th>
							<th>'.$infoReservation["MailPersonneReserve"].'</th>
							<th>'.$infoReservation["Local"].'</th>
							<th>'.$infoReservation["Date"].'</th>';
							echo ' <th><img src=img/trash.png style="width:30%; cursor:pointer;" onClick="supprimer('.$infoReservation["idReservation"].')"></th>
						  </tr>';
						} 
					 
                    echo '</table></div></form>';//fermeture form
				   	 /*********************************/	
					/*FIN  FORM POUR VOIR RESERVATION*/
				   /*********************************/
					
					
					
					
					 /***********************************/	
					/*DEBUT FORM POUR VOIR DÉPLACEMENTS*/
				   /***********************************/
				  ?> 
				<form id="formDeplacement" style="display:none;" enctype="multipart/form-data">
                <div align="center"> <br>
						<table id='TablePendant' style="width:95%;">
                        <thead>
						  <tr>
                          	<th>Case à cocher</th>
						  	<th>Oeuvre</th>
                            <th>Titre</th>
							<th>Local de provenance</th> 
							<th>Local d'envoie</th>
							<th>Nouveau Locataire</th>
						  </tr>
                          </thead>
                          <tbody style="background-color:#2E3033;">
                          <?PHP
						   $sql = 'select * from emprunt where confirme = 0';
						  $infoEmpruntOff = $Cnn->prepare($sql);
						  $infoEmpruntOff->execute();
						  while($EmpruntOff = $infoEmpruntOff->fetch())
						  {
							echo '<tr style="background-color:#2E3033;">';  
							$sql2 = 'select * from Oeuvres where idOeuvres = '.$EmpruntOff["idOeuvre"].';';
							$infoOeuvre = $Cnn->prepare($sql2);
							$infoOeuvre->execute();	
							echo '<th> <input type="checkbox" id="checkbox'.$EmpruntOff["idOeuvre"].'true" name="checkbox" onclick="onCheck('.$EmpruntOff["idOeuvre"].',true)"></th>';
							echo '<th>';
							if ($Oeuvre = $infoOeuvre->fetch())
							{
								echo '<img src="img/categorie/'.$Oeuvre['nomOeuvre'].'"style="width:125px; height:auto;">';
								echo'</th>';
							    echo'<th>';
							    echo $Oeuvre['Titre'];
							    echo'</th>';
								echo '<th>';
								echo $Oeuvre['lieu'];
								echo '</th>';
							}
							echo '<th>Entrepôt</th>';
							echo '<th>Entrepôt</th>';
							echo '</tr>';
						  }
						  $infoProchaineReservation = $Cnn->prepare('Select * from reservation where effectif = 1 and idOeuvre NOT IN (select idOeuvre from emprunt where confirme = 1) order by idOeuvre,date');
						  $infoProchaineReservation->execute();
						  $nb;
						  $found = false;
						  $idOeuvre = "";
						  while($Deplacement = $infoProchaineReservation->fetch())
						  {
							  if ($idOeuvre != $Deplacement['idOeuvre'])
							  {
							 	 $idOeuvre = $Deplacement['idOeuvre'];
								 $found = false;
							  }
							  $sql3 = 'select count(*) as nb from emprunt where MailPersonneEmprunt = "'.$Deplacement["MailPersonneReserve"].'" and confirme = 1;';
							  $infoCount = $Cnn->prepare($sql3);
							  $infoCount->execute();
							  if ($nombre = $infoCount->fetch())
							  {
								  $nb = $nombre['nb'];
							  }
							  
							  if ($nb < 2 && $found == false)
							  {
								  $found = true;
								  $sql2 = 'select * from Oeuvres where idOeuvres = '.$Deplacement["idOeuvre"].';';
								  $infoOeuvre = $Cnn->prepare($sql2);
								  $infoOeuvre->execute();
								  echo '<tr style="background-color:#2E3033;">';
							 echo '<th> <input type="checkbox" id="checkbox'.$Deplacement["idOeuvre"].'false" name="chekbox"  onclick="onCheck('.$Deplacement["idOeuvre"].',false)"></th>';
								  echo '<th>';
								 if ($Oeuvre = $infoOeuvre->fetch())
								{
									echo '<img src="img/categorie/'.$Oeuvre['nomOeuvre'].'"style="width:125px; height:auto;">';
								    echo'</th>';
								    echo'<th>';
								    echo $Oeuvre['Titre'];
								    echo'</th>';
									$sql = 'select idOeuvre from Emprunt where confirme = 0 and idOeuvre ='.$Oeuvre["idOeuvres"];
									echo '<th>';
									$infoEntrepot = $Cnn->prepare($sql);
									$infoEntrepot ->execute();
									if ($infoEntrepot->fetch() == true)
									{
										echo 'Entrepôt';
									}
									else
									{
										echo $Oeuvre['lieu'];
									}
									echo '</th>';
								}
								echo '<th>'.$Deplacement['Local'].'</th>';
								echo '<th>'.$Deplacement['PrenomPersonneReserve'].' '.$Deplacement['NomPersonneReserve'].'</th>';
										
								echo '</th>';
								echo '</tr>';
							  }
						  }		 
                    echo '</tbody></table></div>';
					echo '</form>';//fermeture form*/
				   	 /**********************************/	
					/*FIN  FORM POUR VOIR DÉPLACEMENTS*/
				   /**********************************/
					
					 /***************************************/	
					/*DEBUT FORM POUR VOIR DÉPLACEMENTS FIN*/
				   /***************************************/
				   		$infoProchaineReservation = $Cnn->prepare('Select * from (select * from reservation where effectif = 1 order by date) as info group by idOeuvre');
						$infoProchaineReservation->execute();
				  ?> 
				<form id="formDeplacementFin" style="display:none;" enctype="multipart/form-data">
               <div align="center"> <br>
						<table id='TableFin' style="width:95%;">
                        <thead>
						  <tr>
                          	<th>Case à cocher</th>
						  	<th>Oeuvre</th>
                            <th>Titre</th>
							<th>Local de provenance</th> 
							<th>Local d'envoie</th>
							<th>Nouveau Locataire</th>
						  </tr>
                          </thead>
                          <tbody style="background-color:#2E3033;">
                          <?PHP
						   $sql = 'select * from emprunt where confirme = 0';
						  $infoEmpruntOff = $Cnn->prepare($sql);
						  $infoEmpruntOff->execute();
						  while($EmpruntOff = $infoEmpruntOff->fetch())
						  {
							echo '<tr style="background-color:#2E3033;">';  
							$sql2 = 'select * from Oeuvres where idOeuvres = '.$EmpruntOff["idOeuvre"].';';
							$infoOeuvre = $Cnn->prepare($sql2);
							$infoOeuvre->execute();	
							echo '<th> <input type="checkbox" id="checkbox'.$EmpruntOff["idOeuvre"].'true" name="checkbox" onclick="onCheck('.$EmpruntOff["idOeuvre"].',true)"></th>';
							echo '<th>';
							if ($Oeuvre = $infoOeuvre->fetch())
							{
								echo '<img src="img/categorie/'.$Oeuvre['nomOeuvre'].'"style="width:125px; height:auto;">';
								echo'</th>';
							    echo'<th>';
							    echo $Oeuvre['Titre'];
							    echo'</th>';
								echo '<th>';
								echo $Oeuvre['lieu'];
								echo '</th>';
							}
							echo '<th>Entrepôt</th>';
							echo '<th>Entrepôt</th>';
							echo '</tr>';
						  }
						  $infoEmpruntOff->closeCursor();
						   $infoProchaineReservation = $Cnn->prepare('SELECT * FROM(Select * FROM reservation WHERE reservation.effectif = 1  Order By reservation.Date ASC) as tmp_table GROUP BY IdOeuvre;');
						  $infoProchaineReservation->execute();
						  while($Deplacement = $infoProchaineReservation->fetch())
						  {
								  $sql2 = 'select * from Oeuvres where idOeuvres = '.$Deplacement["idOeuvre"].';';
								  $infoOeuvre = $Cnn->prepare($sql2);
								  $infoOeuvre->execute();
								  echo '<tr style="background-color:#2E3033;">';
							 echo '<th> <input type="checkbox" id="checkbox'.$Deplacement["idOeuvre"].'false" name="chekbox"  onclick="onCheck('.$Deplacement["idOeuvre"].',false)"></th>';
								  echo '<th>';
								 if ($Oeuvre = $infoOeuvre->fetch())
								{
									echo '<img src="img/categorie/'.$Oeuvre['nomOeuvre'].'"style="width:125px; height:auto;">';
								    echo'</th>';
								    echo'<th>';
								    echo $Oeuvre['Titre'];
								    echo'</th>';
									$sql = 'select idOeuvre from Emprunt where confirme = 0 and idOeuvre ='.$Oeuvre["idOeuvres"];
									echo '<th>';
									$infoEntrepot = $Cnn->prepare($sql);
									$infoEntrepot ->execute();
									if ($infoEntrepot->fetch() == true)
									{
										echo 'Entrepôt';
									}
									else
									{
										echo $Oeuvre['lieu'];
									}
									echo '</th>';
								echo '<th>'.$Deplacement['Local'].'</th>';
								echo '<th>'.$Deplacement['PrenomPersonneReserve'].' '.$Deplacement['NomPersonneReserve'].'</th>';
								}
										
								echo '</th>';
								echo '</tr>';
						  }		 
                    echo '</tbody></table></div>';
					echo '</form>';
				   	 /**************************************/	
					/*FIN  FORM POUR VOIR DÉPLACEMENTS FIN*/
				   /**************************************/
					
					
					 /****************************************/	
					/*DEBUT FORM DE L'AJOUT DE COMMANDITAIRE*/
				   /****************************************/
					?>
                    <form id="formAjoutCommanditaire" style="display:none;" action="ajoutCommanditaire.php?email=<?PHP echo $email;?>" method="POST" enctype="multipart/form-data">
				<div align="center"> <br>Nom du commanditaire
                       <input class="form-control-little" id="commanditaire" name="commanditaire" placeholder="Entrez le nom du commanditaire"></input>
                   <label style="margin-left:40%;" for="image">Image
                     <input type="file" name="image" id="image"></label><br><br><br>
									
                   <button type="submit" class="btn tf-btn btn-notdefault">Ajouter</button></div>
                   </form>
                   <?PHP
				   	 /**************************************/	
					/*FIN FORM DE L'AJOUT DE COMMANDITAIRE*/
				   /**************************************/
				     /***************************************/	
					/*DEBUT FORM DE DELETE DE COMMANDITAIRE*/
				   /***************************************/
				$reponseCommanditaire = $Cnn->prepare('Select nomCommanditaire,idCommanditaire from commanditaire;');
						$reponseCommanditaire->execute();
					echo '<form id="formSprmCommanditaire" style="display:none;" action="supprimerCommanditaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
									 echo ' <div align="center"> Nom du commanditaire
                                    <select class="form-control-little" id="sprmCom" name="sprmCom">';
									echo '<option id="sprmCom0"></option>';
									while($infoCommanditaire = $reponseCommanditaire->fetch())
									{
										echo '<option id="com'.$infoCommanditaire['idCommanditaire'].'">'.$infoCommanditaire['nomCommanditaire'].'</option>';
									}
									echo'</select><br>';//com
									
                   echo' <button type="submit" class="btn tf-btn btn-notdefault">Supprimer</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /*************************************/	
					/*FIN FORM DE DELETE DE COMMANDITAIRE*/
				   /*************************************/
					
					 /******************************/	
					/*DEBUT FORM POUR VOIR EMPRUNT*/
				   /******************************/
				   				   		$reponseEmprunt = $Cnn->prepare('Select * from emprunt where confirme = 1 order by date;');
						$reponseEmprunt->execute();
				   
				   ?>
					<form id="formEmprunt" style="display:none;" enctype="multipart/form-data">
				<div align="center"> <br>
						<table style="width:95%; margin-left:5%;">
						  <tr>
						  	<th>Oeuvre</th>
							<th>Nom</th> 
							<th>Prenom</th>
							<th>Mail</th>
							<th>Local</th>
							<th>Date</th>
							<th>Supprimer</th>
						  </tr>
                          <?PHP
						  $path = '';
						  $titre = '';
						while ($infoEmprunt = $reponseEmprunt->fetch())
						{
							$reponseOeuvre = $Cnn->prepare('Select Titre,nomOeuvre from oeuvres where idOeuvres = '.$infoEmprunt["idOeuvre"].';');
							$reponseOeuvre->execute();
							if ($oeuvre = $reponseOeuvre->fetch())
							{
								$path = $oeuvre["nomOeuvre"];
								$titre = $oeuvre["Titre"];
							}
						echo ' <tr>
						<th><a href="img/categorie/'.$path.'" data-lightbox="'.$path.'"><u>'.$titre.'</u></a></th>
							<th>'.$infoEmprunt["NomPersonneEmprunt"].'</th>
							<th>'.$infoEmprunt["PrenomPersonneEmprunt"].'</th>
							<th>'.$infoEmprunt["MailPersonneEmprunt"].'</th>
							<th>'.$infoEmprunt["Local"].'</th>
							<th>'.$infoEmprunt["Date"].'</th>';
							echo ' <th><img src=img/trash.png style="width:30%; cursor:pointer;" onClick="supprimerEmprunt('.$infoEmprunt["idEmprunt"].','.$infoEmprunt["idOeuvre"].')"></th>
						  </tr>';
						} 
					 
                    echo '</table></div></form>';//fermeture form
				   	 /****************************/	
					/*FIN FORM POUR VOIR EMPRUNT*/
				   /****************************/
				    			 
					
					/*********************************/	
					/*DEBUT FORM DE L'AJOUT D'OEUVRES*/
					/*********************************/
					echo '<form id="formAjouterOeuvre" style="display:none;"  action="ajoutOeuvre.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
					?>
                    <div align="center"> Auteur <input class="form-control-little" id="auteur" name="auteur" placeholder="Entrez le nom de l'auteur"></input>
					 Titre <input class="form-control-little" id="titre" name="titre" placeholder="Entrez le titre"></input>
					Hauteur <input class="form-control-little" id="hauteur" name="hauteur" placeholder="Entrez la hauteur en centimètre"></input>
					Largeur	<input class="form-control-little" id="largeur" name="largeur" placeholder="Entrez la hauteur en centimètre"></input>
					Profondeur <input class="form-control-little" id="profondeur" name="profondeur" placeholder="Entrez la profondeur en centimètre"></input>
					Emplacement	<input class="form-control-little" id="lieu" name="lieu" placeholder="Entrez l'emplacement(si applicable)"></input>
				Description	<input class="form-control-little" id="description" name="description" placeholder="Entrez un description (facultatif)"></input>	
					 Année	<select class="form-control-little" id="annee" name="annee">
									<option id="annee0"></option>
									<?PHP
									$cpt =  date("Y");
									$cpt2 =  date("Y")-100;
									while ($cpt >= $cpt2)
									{
										echo '<option id="annee'.$cpt.'">'.$cpt.'</option>';
										$cpt--;										
									}
									echo'</select>';//annee							
									
					echo 'Médium
                                    <select class="form-control-little" id="categorie" name="categorie">';
					echo '<option id="categorie0"></option>';
						while($infoCategorie = $reponseCategorie->fetch())
						{
							echo '<option id="categorie'.$infoCategorie['idCategorie'].'">'.$infoCategorie['nomCategorie'].'</option>';
						}
									
						echo'</select>';//Categorie
				
					echo 'État
                                    <select class="form-control-little" id="etat" name="etat">';
					echo '<option id="etat0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="etat'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						
						echo '</select><br>';//etat
						
						
						 echo '<label style="margin-left:40%;" for="image">Image
                     <input type="file" name="image" id="image"></label><br><br><br>';//fichier		
									
                   echo'<button type="submit" class="btn tf-btn btn-notdefault">Ajouter</button></div>';//button
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
				   $titresOeuvre = $Cnn->prepare('Select nomOeuvre,idOeuvres from oeuvres;');
				   $titresOeuvre->execute();
				   echo '<form id="formAllTitre"  style="display:none;">';
				   echo '<br><div align="center"> Toutes les oeuvres';
				  /* echo' <select class="form-control-little" id="allTitre" name="allTitre" onchange="ajaxModifierOeuvre();">';
				   echo '<option id="noTitre"></option>';
				   while ($titreOeuvre = $titresOeuvre->fetch())
				   {
							echo '<option id="'.$titreOeuvre['Titre'].'" value = "'.$titreOeuvre['Titre'].'">'.$titreOeuvre['Titre'].'</option>';									
					}
					echo'</select>;*/
					echo '<table width="100%">';
					$cpt = 5;
					while($Oeuvres = $titresOeuvre->fetch())
					{
						if($cpt%5 == 0)
						{
							echo '<tr>';						
						}
						echo '<th style="text-align:center;" >';
						echo '<img onClick="ajaxModifierOeuvre('.$Oeuvres['idOeuvres'].');" src="img/categorie/'.$Oeuvres['nomOeuvre'].'"style="cursor: pointer;	margin-right:5px; max-width:200px; margin-left:5px;">';
						echo '</th>';
						$cpt++;
					}
					?>
					</table>
					</div>
					</form>
					<form id="formModifierOeuvre" style="display:none;"  action="modifierOeuvre.php?email=<?PHP echo $email;?>" method="POST" enctype="multipart/form-data">
					<br> <a id ='oeuvreImage' data-lightbox='Oeuvre'><p class = 'color'><b><u>VOIR L'OEUVRE</u></b></p></a>
                    <div align="center"> Auteur  <input class="form-control-little" id="auteurM" name="auteurM" placeholder="Entrez le nom de l'auteur"></input>
					 Titre <input class="form-control-little" id="titreM" name="titreM" placeholder="Entrez le titre"></input>
					Hauteur <input class="form-control-little" id="hauteurM" name="hauteurM" placeholder="Entrez la hauteur en centimètre"></input>
					Largeur <input class="form-control-little" id="largeurM" name="largeurM" placeholder="Entrez la hauteur en centimètre"></input>
					Profondeur  <input class="form-control-little" id="profondeurM" name="profondeurM" placeholder="Entrez la profondeur en centimètre"></input>
					Emplacement  <input class="form-control-little" id="lieuM" name="lieuM" placeholder="Entrez l'emplacement(si applicable)"></input>
				Description	<input class="form-control-little" id="descriptionM" name="descriptionM" placeholder="Entrez un description (facultatif)"></input>	
					 Année	<select class="form-control-little" id="anneeM" name="anneeM">
									<option id="anneeM0"></option>
                                    <?PHP
									$cpt = date("Y");
									$cpt2 = date("Y") - 100;
									while ($cpt >=$cpt2)
									{
										echo '<option id="anneeM'.$cpt.'">'.$cpt.'</option>';
										$cpt--;										
									}
									echo'</select>';//annee							
									
					echo 'Catégorie
                                    <select class="form-control-little" id="categorieM" name="categorieM">';
					echo '<option id="categorieM0"></option>';
						while($infoCategorie = $reponseCategorie->fetch())
						{
							echo '<option id="categorieM'.$infoCategorie['idCategorie'].'">'.$infoCategorie['nomCategorie'].'</option>';
						}
									
						echo'</select>';//Categorie
				
					echo 'État
                                    <select class="form-control-little" id="etatM" name="etatM">';
					echo '<option id="etatM0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="etatM'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						
						echo '</select><br>';//etat	
					echo '<input type="hidden" id="idOeuvre" name="idOeuvre">';
                   echo'<button type="submit" class="btn tf-btn btn-notdefault">Modifier</button></div>';//button
                   echo' </form>';//fermeture form
				   	 /***************************/	
					/*FIN FORM MODIFIER OEUVRES*/
				   /***************************/
				   
				   	   
				   
				  	 /******************************/	
					/*DEBUT FORM DE L'AJOUT D'ÉTAT*/
				   /******************************/
					echo '<form id="formEtat" style="display:none;"  action="ajoutEtat.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
					?>
                    <div align="center"> État
                                    <input class="form-control-little" id="etat" name="etat" placeholder="Entrez l'état"></input><br>
									
				<b><i>Indiquez si cette état permet la réservation.</i></b> <select class="form-control-little" id="reservation" name="reservation"><br>
					 <option id="blind"></option>
						<option id="0">Non</option>
						<option id="1">Oui</option>
				</select><br>
									
                  <button type="submit" class="btn tf-btn btn-notdefault">Ajouter</button></div>
                   </form>
                   <?PHP
				   	 /****************************/	
					/*FIN FORM DE L'AJOUT D'ÉTAT*/
				   /****************************/
				   
				   
				   	 /****************************/	
					/*DEBUT FORM DE MODIF D'ÉTAT*/
				   /****************************/
				   
				   
				   	$reponseEtat = $Cnn->prepare('SELECT NomEtat,idetat from etat;');
					$reponseEtat->execute();
					echo '<form id="formAllEtat" style="display:none;" method="POST" enctype="multipart/form-data">';
                   	echo '<div align="center">Tous les états
                                    <select class="form-control-little" id="AllEtat" name="AllEtat" onchange="ajaxModifierEtat();">';
					echo '<option id="allEtat0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="allEtat'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						?>
						
						</select><br></div>
									
                   </form>
				  
				  
				   <form id="formModifierEtat" style="display:none;"  action="modifierEtat.php?email=<?PHP echo $email;?>" method="POST" enctype="multipart/form-data">
				   	<div align="center">État <input class="form-control-little" id="EtatModif" name="EtatModif" placeholder="Entrez l'état"></input> <b><i>Indiquez si cette état permet la réservation.</i></b> <select class="form-control-little" id="reservationModif" name="reservationModif"><br>
						<option id="0">Non</option>
                        <option id="1">Oui</option>

						
				</select><br>
                        <input type="hidden" id="idEtat" name="idEtat">
                        <button type="submit" class="btn tf-btn btn-notdefault">Modifier</button></div>
				    </form>
                    <?PHP
				   	 /**************************/	
					/*FIN FORM DE MODIF D'ÉTAT*/
				   /**************************/
				   
				   
				   	 /************************************/	
					/*DEBUT FORM DE L'AJOUT DE CATÉGORIE*/
				   /************************************/
				   ?>
					<form id="formCategorie" style="display:none;"  action="ajoutCategorie.php?email=<?PHP echo $email;?>" method="POST" enctype="multipart/form-data">
                    <div align="center">Médium
                                    <input class="form-control-little" id="medium" name="medium" placeholder="Entrez le médium"></input><br>
									
                   <button type="submit" class="btn tf-btn btn-notdefault">Ajouter</button></div>
                   </form>
                   <?PHP
				   	 /**********************************/	
					/*FIN FORM DE L'AJOUT DE CATÉGORIE*/
				   /**********************************/
				   
				   	 /**********************************/	
					/*DEBUT FORM DE MODIF DE CATÉGORIE*/
				   /**********************************/
				   
				   
				   	$reponseMedium = $Cnn->prepare('SELECT * from categorie;');
					$reponseMedium->execute();
					echo '<form id="formAllMedium" style="display:none;" method="POST" enctype="multipart/form-data">';
                   	echo '<div align="center">Tous les Médiums
                                    <select class="form-control-little" id="AllMedium" name="AllMedium" onchange="ajaxModifierMedium();">';
					echo '<option id="allMedium0"></option>';
						while($infoMedium = $reponseMedium->fetch())
						{
							echo '<option id="allEtat'.$infoMedium['idCategorie'].'">'.$infoMedium['nomCategorie'].'</option>';
						}
						?>
						</select><br></div>
									
                   </form>
				   
					<form id="formModifierMedium" style="display:none;"  action="modifierMedium.php?email='.$email.'" method="POST" enctype="multipart/form-data">
                   <div align="center">Médium <input class="form-control-little" id="mediumModif" name="mediumModif" placeholder="Entrez le médium"></input><br>
				<input type="hidden" id="idMedium" name="idMedium">			
                   <button type="submit" class="btn tf-btn btn-notdefault">Modifier</button></div>
                   </form>
                   <?PHP
				   	 /********************************/	
					/*FIN FORM DE MODIF DE CATÉGORIE*/
				   /********************************/
				}
			}
			
					if (isset($_GET['deplacement']) && $_GET['deplacement'] == 'true')
					{?>
						<script type="text/javascript">
              			 $('#divRes').slideToggle("slow", function () {});
           				 $('#formDeplacement').slideToggle("slow", function () {});
                         </script>
					<?PHP }
					else if (isset($_GET['reservation']) && $_GET['reservation'] == 'true')
					{?>
						<script type="text/javascript">
                         $('#divRes').slideToggle("slow", function () {});
						 $('#formReservation').slideToggle("slow", function () {});
                        </script>
					<?PHP }
					else if (isset($_GET['emprunt']) && $_GET['emprunt'] == 'true')
					{?>
						<script type="text/javascript">
                        $('#divEmprunt').slideToggle("slow", function () {});
						$('#formEmprunt').slideToggle("slow", function () {});
                        </script>
					<?PHP }
					else if (isset($_GET['fin']) && $_GET['fin'] == 'true')
					{?>
						<script type="text/javascript">
                        $('#divEmprunt').slideToggle("slow", function () {});
						$('#formDeplacementFin').slideToggle("slow", function () {});
                        </script>
					<?PHP }
			
			
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
<script type="text/javascript"src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
<script type="text/javascript"src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script>
$("#formEmprunt").validate(
	{	rules:
		{	mail: {	required:true,	
						regex_E:true
					},
			password: {	required:true
					}
		},
		messages : { 			mail : {required : 'Le email est obligatoire',
										regex_E :'Doit etre de format @cegepba.qc.ca'
								},
								password:{required:'Le mot de pass est obligatoire'}
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
								reservation : {required : 'La possibilité est obligatoire'}
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
			$('#divEmprunt').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formEmprunt').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#divRes').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}	
		function reservation() {
			$('#divRes').slideToggle("slow", function () {
			});
			$('#divCom').css('display', 'none');
			$('#divEmprunt').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formEmprunt').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
		    $('#formSprmCommanditaire').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}	
		function emprunt() {
			$('#divEmprunt').slideToggle("slow", function () {
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
			 $('#formDeplacement').css('display', 'none');
		}
			function oeuvre() {
			$('#divOv').slideToggle("slow", function () {
			});
			$('#divEmprunt').css('display', 'none');
			 $('#divCom').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCat').css('display', 'none');
			 $('#formAjoutCommanditaire').css('display', 'none');
			 $('#formEmprunt').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			  $('#formAllTitre').css('display', 'none');
			  $('#formSprmCommanditaire').css('display', 'none');
			  $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#divRes').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function etat() {
			$('#divEtat').slideToggle("slow", function () {
			});
			$('#divEmprunt').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divCom').css('display', 'none');
			 $('#divCat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formCategorie').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#divRes').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function categorie() {
			$('#divCat').slideToggle("slow", function () {
			});
			$('#divEmprunt').css('display', 'none');
			 $('#divOv').css('display', 'none');
			 $('#divEtat').css('display', 'none');
			 $('#divCom').css('display', 'none');
			 $('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#divRes').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}
		
	function voirEmprunt() {
			$('#formEmprunt').slideToggle("slow", function () {
			});
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
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function ajouterOeuvre() {
			$('#formAjouterOeuvre').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formEmprunt').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function afficherTitre() {
			$('#formAllTitre').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formEmprunt').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			  $('#formAjouterOeuvre').css('display', 'none');
			  $('#formModifierOeuvre').css('display', 'none');
			  $('#formSprmCommanditaire').css('display', 'none');
			  $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function modifierOeuvre() {
			$('#formModifierOeuvre').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			 $('#formEmprunt').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			  $('#formAjouterOeuvre').css('display', 'none');
			  $('#formAllTitre').css('display', 'none');
			  $('#formSprmCommanditaire').css('display', 'none');
			  $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function ajouterEtat() {
			$('#formEtat').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formCategorie').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formSprmCommanditaire').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function ajouterCategorie() {
			$('#formCategorie').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
			function ajouterCommanditaire() {
			$('#formAjoutCommanditaire').slideToggle("slow", function () {
			});
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function sprmCommanditaire(){
				$('#formSprmCommanditaire').slideToggle("slow", function () {
			});
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			 $('#formAjouterOeuvre').css('display', 'none');
			 $('#formEtat').css('display', 'none');
			 $('#formCategorie').css('display', 'none');
			 $('#formModifierOeuvre').css('display', 'none');
			 $('#formAllTitre').css('display', 'none');
			 $('#formModifierEtat').css('display', 'none');
			 $('#formModifierMedium').css('display', 'none');
			 $('#formAllEtat').css('display', 'none');
			 $('#formAllMedium').css('display', 'none');
			 $('#formReservation').css('display', 'none');
			 $('#formDeplacement').css('display', 'none');
			 $('#formDeplacementFin').css('display', 'none');
		}
		function modifierEtat(){
				$('#formModifierEtat').slideToggle("slow", function () {
			});
			$('#formModifierMedium').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}
		function afficherEtat(){
				$('#formAllEtat').slideToggle("slow", function () {
			});
			$('#formModifierEtat').css('display', 'none');
			$('#formModifierMedium').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}
		function modifierMedium(){
				$('#formModifierMedium').slideToggle("slow", function () {
			});
			$('#formCategorie').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}
		
		function afficherMedium(){
				$('#formAllMedium').slideToggle("slow", function () {
			});
			$('#formCategorie').css('display', 'none');
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formModifierMedium').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}

		
		function voirReservation(){
			$('#formReservation').slideToggle("slow", function () {
			});
			$('#formModifierMedium').css('display', 'none')
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formDeplacement').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}	
		function voirDeplacementsAnnee(){
				$('#formDeplacement').slideToggle("slow", function () {
			});
			$('#formReservation').css('display', 'none');
			$('#formModifierMedium').css('display', 'none')
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
			$('#formDeplacementFin').css('display', 'none');
		}
		function voirDeplacementsFin(){
				$('#formDeplacementFin').slideToggle("slow", function () {
			});
			$('#formDeplacement').css('display', 'none');
			$('#formReservation').css('display', 'none');
			$('#formModifierMedium').css('display', 'none')
			$('#formModifierEtat').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formAjoutCommanditaire').css('display', 'none');
			$('#formEmprunt').css('display', 'none');
			$('#formAjouterOeuvre').css('display', 'none');
			$('#formEtat').css('display', 'none');
			$('#formModifierOeuvre').css('display', 'none');
			$('#formAllTitre').css('display', 'none');
			$('#formSprmCommanditaire').css('display', 'none');
			$('#formAllEtat').css('display', 'none');
			$('#formAllMedium').css('display', 'none');
		}
	function ajaxModifierOeuvre(id)
	{ 
    	$.ajax({
				url: "chercherInfosOeuvres.php", 
				type: 'POST',
				dataType: 'html',
				data:{id:id},
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
function supprimer(idReservation)
{
	if (confirm('Voulez-vous vraiment supprimer cette réservation?')) {
	 $.ajax({
		  url : "SupprimerReserv.php",
		  type : 'POST',
		  dataType:'html',
		  data : {idReservation:idReservation},
		  success: function(output)
		  			{
						alert("Supression de réservation effectuée");
						document.location.href="gestionnaire.php?reservation=true";
					},
		});
	}
}
function supprimerEmprunt(idEmprunt,idOeuvre)
{
	if (confirm('Voulez-vous vraiment confirmer cet emprunt?')) {
	 $.ajax({
		  url : "SupprimerEmprunt.php",
		  type : 'POST',
		  dataType:'html',
		  data : {idEmprunt:idEmprunt,idOeuvre:idOeuvre},
		  success: function(output)
		  			{
						alert("Supression d'emprunt effectuée");
						document.location.href="gestionnaire.php?emprunt=true";
					},
		});
	}
}
	function menu(){
	 $('.navbar-default').addClass('on');
	}
	
	function onCheck(idOeuvre,choice){
		if (confirm('Voulez-vous vraiment confirmer ce déplacement?')) {
			 $.ajax({
			  url : "confirmerDeplacement.php",
			  type : 'POST',
			  dataType:'html',
			  data : {idOeuvre:idOeuvre,choice:choice},
			  success: function(output)
						{
							alert("Confirmation effectuée!");
							document.location.href="gestionnaire.php?deplacement=true";
						},
			});
		} else {
			document.getElementById('checkbox'+idOeuvre+choice).checked = false;
		}

	}
	$(document).ready(function(){
    $('#TablePendant').DataTable({
	"bPaginate":false,
	        dom: 'Bfrtip',
        buttons: [
		{
            extend:'print',
			text:'Imprimer',
			exportOptions:{
				stripHtml:false,
				columns : [1,2,3,4,5]
			}
		}
        ],
		"language":{"search":"Rechercher :"},
	});
	
	 $('#TableFin').DataTable({
	"bPaginate":false,
	    dom: 'Bfrtip',
        buttons: [
		{
            extend:'print',
			text:'Imprimer',
			exportOptions:{
				stripHtml:false,
				columns : [1,2,3,4,5]
			}
		}
        ],
		"language":{"search":"Rechercher :"},
	});
});
</script>

  </body>
  <div style="position:fixed; width:100%;">
       <?PHP include('includes/Footer.php'); ?>
       </div>
</html>