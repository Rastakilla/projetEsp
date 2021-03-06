<!DOCTYPE html>
<html lang="en">
  <head>
    <?PHP
	session_start();
  include('connexionBd.php');
 $cpt = 0;
  ?>
    <style>
  label.error{
	color: red;
}
</style>
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
  <body onload ="menu();" style='height:100vh; width:100%'>
   <?PHP
   		if (isset($_GET['etat']) && $_GET['etat']!=NULL)
		{
			$etat = $_GET['etat'];
		}
		else if (isset($_GET['categorie']) && $_GET['categorie']!=NULL)
		{
			$categorie = ($_GET['categorie']);
		}
		else if (isset($_GET['dimensions']) && $_GET['dimensions']!=NULL && $_GET['dimensions']==true)
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
		else if(isset($_GET['motcle']) && $_GET['motcle']!=NULL && $_GET['motcle']==true)
		{
			$motcle = 'Mot Clé';
			if (isset($_GET['infoMotCle']) && $_GET['infoMotCle']!= '')
			{
				$infoMotCle = $_GET['infoMotCle'];
			}
		}
		else if (isset($_GET['idOeuvre']) && $_GET['idOeuvre']!=NULL)
		{
			$idOeuvre = htmlentities($_GET['idOeuvre']);
			if (isset($_GET['reserver'])  && $_GET['reserver'] != NULL && $_GET['reserver'] == 'true')
			{
				$reserver = 'Reserver';
			}
			else
			{
				$_SESSION['acces'] = 'non';
				header('Location: index.php');
			}
		}
		else
		{
			$_SESSION['acces'] = 'non';
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
				if (isset($idOeuvre))
				{
					$Medium = true;
					$whereGlobal = ' where oeuvres.idOeuvres ="'.$idOeuvre.'";';	
					if (isset($reserver))
					{
						$sql = 'select idetat from etat where peuxEtreReserve = 1';
						$infoEtat = $Cnn->prepare($sql);
						$infoEtat->execute();
						$cpt = 0;
						$whereEtat = ' idEtat=';
						while ($Etats = $infoEtat->fetch())
						{
							if ($cpt == 0)
							{
								$whereEtat = $whereEtat.$Etats['idetat'];
							}
							else
							{
								$whereEtat= $whereEtat.' or idEtat='.$Etats['idetat'];
							}
							$cpt++;
						}
												
						$sql = 'select nomOeuvre from oeuvres where idOeuvres = '.$idOeuvre.' and ('.$whereEtat.');';
						$infoBonneOeuvre = $Cnn->prepare($sql);
						$infoBonneOeuvre->execute();
						if ($infoBonneOeuvre->fetch() == false)
						{
							$_SESSION['acces'] = 'non';
							header('location:index.php');
						}
						else
						{
							$Medium = true;
							echo '<h2><strong>'.$reserver.' une oeuvre</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
						}
					}
					else
					{
						header('Location: index.php');
					}
				}
				if (isset($etat))
				{
					$Medium = true;
					echo '<h2><strong>'.$etat.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					$whereGlobal = ' where etat.NomEtat ="'.$etat.'";';	
				}
				else if (isset($categorie))
				{
					$Medium = false;
					echo '<h2><strong>'.$categorie.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					$whereGlobal =  ' where categorie.nomCategorie = "'.$categorie.'";';
                 }
				 else if (isset($motcle))
				{
					$Medium = true;
					$whereGlobal = '';
					if (isset($infoMotCle))
					{
						$whereGlobal = " where description like '%".$infoMotCle."%' or Titre like '%".$infoMotCle."%';";
					}
					echo '<h2><strong>'.$motcle.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					 echo ' <div align="center">
                                    <input class="form-control-little" id="infoMotCle" name="infoMotCle" placeholder="Mot Clé"></input></div>';
					echo '<button type="button" class="btn tf-btn btn-notdefault" onclick="RechercherMotCle();">Rechercher</button><br><br>';
                 }
				 else if(isset($dimensions))
				 {
					 $Medium = true;
				    echo '<h2><strong>'.$dimensions.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>'; ?>
					<div align="center">
					 Hauteur
                                    <input type="number" class="form-control-little" id="hauteur" name="hauteur" placeholder="Hauteur(cm)"></input>Largeur
                                    <input  type="number" class="form-control-little" id="largeur" name="largeur" placeholder="Largeur(cm)"></input>Profondeur
                                    <input  type="number" class="form-control-little" id="profondeur" name="profondeur" placeholder="Profondeur(cm)"></input><br>
					<button type="button" class="btn tf-btn btn-notdefault" onclick="RechercherDimensions();">Rechercher</button></div><br><br>
                    <?PHP
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
						$whereGlobal = $where.$prefixH.$prefixL.$prefixP;
				 }
				 else if(isset($annee))
				 {
					$Medium = true; 					
					echo '<h2><strong>'.$annee.'</strong></h2><br><i>Cliquez sur l\'oeuvre pour l\'agrendir!</i><br><br>';
					$whereGlobal = ' where Annee = '.$annee;	
				 }
				 $reponseOeuvres = $Cnn->prepare('SELECT idOeuvres,nomOeuvre,peuxEtreReserve,Auteur,Hauteur,Largeur,Profondeur,Titre,Annee,NomEtat,lieu,description,nomCategorie FROM oeuvres inner join etat on oeuvres.idEtat = etat.idetat inner join categorie on oeuvres.idCategorie = categorie.idcategorie'.$whereGlobal);
						$reponseOeuvres->execute();
						if(!isset($idOeuvre))
						{
							 echo '<table  style="margin-left:2%;">';
									$cpt = 2;
						}
					while($infoOeuvres = $reponseOeuvres->fetch())
					{
						$contour = '#ff1111';
						if($infoOeuvres['peuxEtreReserve'] == 1)
						{
							$contour = '#80f442';
						}
						if(!isset($idOeuvre))
						{
						if($cpt%2 == 0)
							{
								echo '<tr>';						
							}
						}
						echo '<th style="text-align:center;" ><a href="img/categorie/'.$infoOeuvres['nomOeuvre'].'" data-lightbox="'.$infoOeuvres['nomOeuvre'].'"><img src="img/categorie/'.$infoOeuvres['nomOeuvre'].'"style="cursor: pointer;	margin-right:50px; max-width:500px; margin-left:50px; border: 3px solid '.$contour.'"></a>';
						if(!isset($idOeuvre))
						{
							if($infoOeuvres['peuxEtreReserve'] == 1)
							{
								echo '<form method="post" action="oeuvres.php?reserver=true&idOeuvre='.$infoOeuvres["idOeuvres"].'">
							  <br><button type="submit" class="btn tf-btn btn-notdefault" />Réserver cette oeuvre </button>
							</form>';		
							}
							else
							{
								echo '<br>';
							}
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
					
					if(!isset($idOeuvre))
					{
						echo'</table>';
					}
					else
					{
						$bouton = NULL;
						if(isset($reserver))
						{
							$bouton = $reserver;
						}
						?>
					<form id="infoClient" action="verificationClient.php?type=<?PHP echo $bouton;?>&idOeuvre=<?PHP echo $_GET['idOeuvre'];?>" method="POST">
                     <div align="center"> <br>
                      Prenom
                                    <input class="form-control-little" id="prenomClient" name="prenomClient" placeholder="Entrez votre prenom"></input>
                      Nom
                                    <input class="form-control-little" id="nomClient" name="nomClient" placeholder="Entrez votre nom"></input>
                     Local
                                    <input class="form-control-little" id="localClient" name="localClient" placeholder="Entrez votre local"></input>               
                     Email
                                    <input class="form-control-little" id="emailClient" name="emailClient" placeholder="Entrez votre adresse Email"></input><br></div>
                    <div><button type="submit" class="btn tf-btn btn-notdefault"> <?PHP echo $bouton;?></button></div>
                    </form>
					<?PHP }
						echo '<br><br><br><br><br><br>';
                   include_once('includes/Footer.php');						
					?> 
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
	<script type="text/javascript" src="jquery-validation-1.15.0/lib/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="jquery-validation-1.15.0/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="jquery-validation-1.15.0/dist/localization/messages_fr.js"></script>
    <!-- Javascripts
    ================================================== -->
    
    <?PHP
	$sql = 'select value from variable where nomVariable = "extensionCourriel"';
	$infoCourriel = $Cnn->prepare($sql);
	$infoCourriel->execute();
	$Courriel;
	if ($info = $infoCourriel->fetch())
	{
		$Courriel = $info['value'];
	}
	?>
    <script>
	var extensionMail = "<?PHP echo $Courriel; ?>";
	function menu(){
	 $('.navbar-default').addClass('on');
	}
	function RechercherDimensions(){
	document.location.href="oeuvres.php?dimensions=true&Hauteur="+document.getElementById('hauteur').value+"&Largeur="+document.getElementById('largeur').value+"&Profondeur="+document.getElementById('profondeur').value;
	}
	function RechercherMotCle(){
		document.location.href="oeuvres.php?motcle=true&infoMotCle="+document.getElementById('infoMotCle').value;
	}
	$("#infoClient").validate(
	{	rules:
		{	prenomClient: {	required:true			
					},
			nomClient: {	required:true			
					},
			localClient: {	required:true	
					},
			emailClient: {	required:true,
				   			 regex_E: true				
					}
		},
		messages : { 			 emailClient : {required : 'Le email est obligatoire',
										regex_E :'Doit etre de format @'+extensionMail
								},
								nomClient :{ required : 'Le nom est obligatoire'},
								prenomClient :{ required : 'Le prenom est obligatoire'},
								localClient :{ required : 'Le local est obligatoire'}
					}
	}
);
	

$.validator.addMethod("regex_E", 
		function (value, element){
				var patt = new RegExp("^[a-zA-Z0-9]+@"+extensionMail+"$","g");
				return this.optional(element) || patt.test(value);
			});
			$.validator.addMethod("regex_N", 
		function (value, element){
				return this.optional(element) || /^[0-9]$/.test(value);
			});
	</script>

  </body>
</html>