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
	<?PHP include('includes/HeaderOeuvres.php'); ?>

    <!-- Oeuvres
    ==========================================-->
    <div id="tf-verif" class="text-center">
        <div class="overlay">
            <div class="content">
            <?PHP
			if (isset($_SESSION['Uploader']) && $_SESSION['Uploader'] == 'True')
			{
	  			  echo '<script>alert("Ajout effectué.");</script>';				
			}
            if (isset($_GET['id']) && htmlentities($_GET['id']))
			{
				$email = htmlentities($_GET['id']);
				$verificateur = false;
				$reponseGestionnaire = $Cnn->prepare('SELECT email from gestionnaire;');
				$reponseGestionnaire->execute();
				while($infoGestionnaire = $reponseGestionnaire->fetch())
				{
					if ($email == $infoGestionnaire['email'])
					{
						$verificateur = true;
					}
				}
				if ($verificateur == false)
				{
					header('Location : index.php');
					$_SESSION['acces'] = 'non';
				}
				else// TODO:ajouter choix modifier ou ajouter ,puis ajouter categorie, etat style="display:none;"
				{
						$reponseEtat = $Cnn->prepare('SELECT NomEtat,idetat from etat;');
						$reponseEtat->execute();
						$reponseCategorie = $Cnn->prepare('SELECT nomCategorie,idCategorie from categorie;');
						$reponseCategorie->execute();
					echo '<form id="gestionnaire" action="ajoutGestionnaire.php?email='.$email.'" method="POST" enctype="multipart/form-data">';
                    echo ' <div> <label>Auteur</label>
                                    <input class="form-control" id="auteur" name="auteur" placeholder="Entrez le nom de l\'auteur"></input><br></div>';//auteur
					echo ' <div> <label>Dimensions</label>
                                    <input class="form-control" id="dimensions" name="dimensions" placeholder="Entrez les dimensions en centimètre"></input><br></div>';//dimensions
					 echo ' <div> <label>Titre</label>
                                    <input class="form-control" id="titre" name="titre" placeholder="Entrez le titre"></input><br></div>';//titre
					echo ' <div> <label>Emplacement</label>
                                    <input class="form-control" id="lieu" name="lieu" placeholder="Entrez l\'emplacement(si applicable, local ou endroit)"></input><br></div>';//lieu
					 echo ' <div> <label>Année</label>
                                    <select class="form-control" id="annee" name="annee">';
									echo '<option id="annee0"></option>';
									$cpt = 1900;
									while ($cpt <= date("Y"))
									{
										echo '<option id="annee'.$cpt.'">'.$cpt.'</option>';
										$cpt++;										
									}
									echo'</select><br></div>';//annee							
									
					echo ' <div> <label>Catégorie</label>
                                    <select class="form-control" id="categorie" name="categorie">';
					echo '<option id="categorie0"></option>';
						while($infoCategorie = $reponseCategorie->fetch())
						{
							echo '<option id="categorie'.$infoCategorie['idCategorie'].'">'.$infoCategorie['nomCategorie'].'</option>';
						}
									
						echo'</select><br></div>';//Categorie
				
					echo ' <div> <label>État</label>
                                    <select class="form-control" id="etat" name="etat">';
					echo '<option id="etat0"></option>';
						while($infoEtat = $reponseEtat->fetch())
						{
							echo '<option id="etat'.$infoEtat['idetat'].'">'.$infoEtat['NomEtat'].'</option>';
						}
						
						echo '</select><br></div>';//etat
						
						
						 echo '<div><label for="image">Image</label><br>
                     <input type="file" name="image" id="image"></div>';//fichier		
									
                   echo' <div><button type="submit" class="btn tf-btn btn-default">Ajouter</button></div>';//button
                   echo' </form>';//fermeture form
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
$("#gestionnaire").validate(
	{	rules:
		{	auteur: {	required:true,			
					},
			dimensions: {	required:true,			
					},
			titre: {	required:true,			
					},
			emplacement: {	required:true,			
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
								dimensions : {required : 'Les dimensions sont obligatoires'},
								titre : {required : 'Le titre est obligatoire'},
								emplacement : {required : 'L\'emplacement est obligatoire'},
								annee : {required : 'L\'année est obligatoire'},
								categorie : {required : 'La categorie est obligatoire'},
								etat : {required : 'L\'etat est obligatoire'},
								image : {required : 'L\'image est obligatoire'}
					}
	}
);

</script>

  </body>
                    	<?PHP include('includes/Footer.php'); ?>
</html>