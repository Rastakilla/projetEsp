<!DOCTYPE html>
<html lang="en">
  <head>
    <?PHP
  include('connexionBd.php');
  ?>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=9" />
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
  <body onload ="menu();" style='height:100vh;'>
   <?PHP
   		if (isset($_GET['etat']) && $_GET['etat']!=NULL)
		{
			$etat = $_GET['etat'];
		}
		else if (isset($_GET['categorie']) && $_GET['categorie']!=NULL)
		{
			$categorie = ($_GET['categorie']);
		}
		else if (isset($_GET['dimensions']) && $_GET['dimensions']!=NULL)
		{
			$dimensions = 'Dimensions';
			if (isset($_GET['Hauteur']) && $_GET['Hauteur'] != '')
			{
				$Hauteur = $_GET['Hauteur'];
			}
			if (isset($_GET['Largeur']) && $_GET['Largeur'] != '')
			{
				$Largeur = $_GET['Largeur'];
			}
			if (isset($_GET['Profondeur']) && $_GET['Profondeur'] != '')
			{
				$Profondeur = $_GET['Profondeur'];
			}
		}
		else if (isset($_GET['annee']) && $_GET['annee']!=NULL)
		{
			$annee = htmlentities($_GET['annee']);
		}
		else
		{
			header('Location: index.php');
		}
		?>
	<?PHP include('includes/HeaderOeuvres.php'); ?>

    <!-- Oeuvres
    ==========================================-->
    <div id="tf-oeuvres" class="text-center">
        <div class="overlay" >
                <?PHP
				$Medium = true;
				if (isset($etat))
				{
					echo '<h2><strong>'.$etat.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre,peuxEtreReserve,Auteur,Hauteur,Largeur,Profondeur,Titre,Annee,NomEtat,lieu,description,nomCategorie FROM oeuvres inner join etat on oeuvres.idEtat = etat.idetat inner join categorie on oeuvres.idCategorie = categorie.idcategorie where etat.NomEtat = :varEtat;');
						$reponseOeuvres->execute(array("varEtat" =>$etat));	
				}
				else if (isset($categorie))
				{
					$Medium = false;
					echo '<h2><strong>'.$categorie.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre,peuxEtreReserve,Auteur,Hauteur,Largeur,Profondeur,Titre,Annee,NomEtat,lieu,description FROM oeuvres inner join etat on oeuvres.idEtat = etat.idetat inner join categorie on oeuvres.idCategorie = categorie.idcategorie where categorie.nomCategorie = :varCat;');
						$reponseOeuvres->execute(array("varCat" =>$categorie));
                 }
				 else if(isset($dimensions))
				 {
				    echo '<h2><strong>'.$dimensions.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					 echo ' <div align="center">
                                    <input class="form-control-little" id="hauteur" name="hauteur" placeholder="Hauteur(cm)"></input>
                                    <input class="form-control-little" id="largeur" name="largeur" placeholder="Largeur(cm)"></input>
                                    <input class="form-control-little" id="profondeur" name="profondeur" placeholder="Profondeur(cm)"></input><br></div>';
					echo '<button type="button" class="btn tf-btn btn-notdefault" onclick="Rechercher();">Rechercher</button><br><br>';
					$where = '';
					$prefixH = '';
					$prefixL = '';
					$prefixP = '';
					if (isset($Hauteur))
					{
						$where = ' where ';
						$prefixH = 'Hauteur <='.$Hauteur;
					}
					if (isset($Largeur))
					{
						$where = ' where ';
						$prefixL = 'Largeur <='.$Largeur;
					}
					if (isset($Profondeur))
					{
						$where = ' where ';
						$prefixP = 'Profondeur <='.$Profondeur;
					}
					if (isset($Hauteur) && isset($Largeur))
					{
						$where = ' where ';
						$prefixH = 'Hauteur <='.$Hauteur;
						$prefixL = ' AND Largeur <='.$Largeur;
					}
					if (isset($Hauteur) && isset($Profondeur))
					{
						$where = ' where ';
						$prefixH = 'Hauteur <='.$Hauteur;
						$prefixP =  ' AND Profondeur <='.$Profondeur;
					}
					if (isset($Largeur) && isset($Profondeur))
					{
						$where = ' where ';
						$prefixL = 'Largeur <='.$Largeur;
						$prefixP = ' AND Profondeur <='.$Profondeur;
					}
					if (isset($Hauteur) && isset($Largeur) && isset($Profondeur))
					{
						$where = ' where ';
						$prefixH = 'Hauteur <='.$Hauteur;
						$prefixL = ' AND Largeur <='.$Largeur;
						$prefixP = ' AND Profondeur <='.$Profondeur;
					}

						$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre,peuxEtreReserve,Auteur,Hauteur,Largeur,Profondeur,Titre,Annee,NomEtat,lieu,description,nomCategorie FROM oeuvres inner join etat on oeuvres.idEtat = etat.idetat inner join categorie on oeuvres.idCategorie = categorie.idcategorie '.$where.$prefixH.$prefixL.$prefixP.';');
						$reponseOeuvres->execute();
				 }
				 else if(isset($annee))
				 {
					 					
					echo '<h2><strong>'.$annee.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre,peuxEtreReserve,Auteur,Hauteur,Largeur,Profondeur,Titre,Annee,NomEtat,lieu,description,nomCategorie FROM oeuvres inner join etat on oeuvres.idEtat = etat.idetat inner join categorie on oeuvres.idCategorie = categorie.idcategorie where Annee = :varAnnee');
						$reponseOeuvres->execute(array("varAnnee" =>$annee));	
				 }
				 echo '<table>';
						$cpt = 2;
					while($infoOeuvres = $reponseOeuvres->fetch())
					{
						$contour = '#ff1111';
						if($infoOeuvres['peuxEtreReserve'] == 1)
						{
							$contour = '#80f442';
						}
						else if ($infoOeuvres['peuxEtreReserve'] == 2)
						{
							$contour = '#fff600';
						}
						if($cpt%2 == 0)
						{
							echo '<tr>';						
						}
						echo '<th style="text-align:center;" ><a href="img/categorie/'.$infoOeuvres['nomOeuvre'].'" data-lightbox="'.$infoOeuvres['nomOeuvre'].'"><img src="img/categorie/'.$infoOeuvres['nomOeuvre'].'"style="cursor: pointer;	margin-right:50px; max-width:500px; margin-left:50px; border: 3px solid '.$contour.'"></a>';
						if($infoOeuvres['peuxEtreReserve'] == 1)
						{
							echo '<a href="">  <u><h4>Emprunter cette oeuvre</h4></u> </a>';			
						}
						else if($infoOeuvres['peuxEtreReserve'] == 2)
						{
							echo '<a href="">  <u><h4>Réserver cette oeuvre</h4></u> </a>';			
						}
						else
						{
							echo '<br>';
						}
						echo '<br>Titre : '.$infoOeuvres['Titre'];
						echo '<br>Année : '.$infoOeuvres['Annee'];
						echo '<br>Auteur : '.$infoOeuvres['Auteur'];
						$profondeur = '';
						if ($infoOeuvres['Profondeur'] != NULL)
						{
							$profondeur = 'x'.$infoOeuvres['Profondeur'];
						}
						echo '<br>Dimension : '.$infoOeuvres['Hauteur'].'x'.$infoOeuvres['Largeur'].$profondeur.' cm';
						echo '<br>État : '.$infoOeuvres['NomEtat'];
						if ($infoOeuvres['lieu'] != '')
						{
							echo '<br>Lieu : '.$infoOeuvres['lieu'];						
						}
						if ($infoOeuvres['description'] != '')
						{
							echo '<br>Description : '.$infoOeuvres['description'];						
						}
						if(isset($Medium) && $Medium == true)
						{
							echo '<br>Médium : '.$infoOeuvres['nomCategorie'];
						}
						echo '</th>';
						$cpt++;
					}
					
					echo'</table><br><br><br><br><br><br>';
                   include('includes/Footer.php');?> 
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
    <script>
	function menu(){
	 $('.navbar-default').addClass('on');
	}
	function Rechercher(){
		alert("oeuvres.php?dimensions=true&Hauteur="+document.getElementById('hauteur').value+"&Largeur="+document.getElementById('largeur').value+"&Profondeur="+document.getElementById('profondeur').value);
	document.location.href="oeuvres.php?dimensions=true&Hauteur="+document.getElementById('hauteur').value+"&Largeur="+document.getElementById('largeur').value+"&Profondeur="+document.getElementById('profondeur').value;
	}
	</script>

  </body>
</html>