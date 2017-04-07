<!DOCTYPE html>
<html lang="en">
  <head>
  <?PHP
  session_start();
  if (isset($_SESSION['acces']) && $_SESSION['acces'] == 'non')
  {
	  echo '<script>alert("Accès refusé.");</script>';
  }
  else if (isset($_SESSION['acces']) && $_SESSION['acces'] == 'oui')
  {
	  	  echo '<script>alert("Un message a été envoyé à votre courriel pour la confirmation.");</script>';
  }
  if(isset($_SESSION['type']) && $_SESSION['type'] != '')
  {
	  if ($_SESSION['type'] == 'Emprunter')
	  {
		  $type = 'Emprunt';
	  }
	  else if ($_SESSION['type'] == 'Reserver')
	  {
		  $type = 'Réservation';
	  }
	  	  echo '<script>alert("'.$type.' effectué.");</script>';
  }
  unset($_SESSION['acces']);
   unset($_SESSION['type']);
  include('connexionBd.php');
  ?>
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

    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="js/modernizr.custom.js"></script>
       <script src="js/jssor.slider-22.2.16.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_options = {
              $AutoPlay: true,
              $SlideDuration: 800,
              $SlideEasing: $Jease$.$OutQuint,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*responsive code begin*/
            /*remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1920);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*responsive code end*/
        };
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<?PHP include('includes/Header.php'); ?>
    <!-- Home Page
    ==========================================-->
    <div id="tf-home" class="text-center">
        <div class="overlay">
            <div class="content">
                <h1>Galerie des  <strong><span class="color">arts</span></strong> visuels</h1>
                <a href="#tf-pic" class="fa fa-angle-down page-scroll">Emprunter</a>
            </div>
        </div>
    </div>

    <!-- Filtre Page
    ==========================================-->
    
    <div id="tf-pic" class="text-center">
        <div class="overlay">
            <div class="container">
            <div>
           		 <h2><i>Type de recherche :</i></h2><br>	
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="Etats();">États</button>&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn tf-btn btn-notdefault" onclick="Mediums();">Médiums</button>&nbsp;&nbsp;&nbsp;
                     					<button type="button" class="btn tf-btn btn-notdefault" onclick="Annees();">Années</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="Dimensions();">Dimensions</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn tf-btn btn-notdefault" onclick="MotCle();">Mot Clé</button>
		   </div>
           
           
           <form id='formEtat' style='display:none;'>
           <div class="section-title center">
                    <h2>Nos <strong>États</strong></h2>
                   			<br> Cliquez pour accéder aux oeuvres de cette état.
                    <div class="line">
                        <hr>
                    </div>
                </div>
				<table width="100%">
                <?PHP
				$reponseEtat = $Cnn->prepare('SELECT nomEtat FROM etat;');
				$reponseEtat->execute();
				$cpt = 0;
				$Etat = array();
				while($infoEtat = $reponseEtat->fetch())
				{
					$Etat[$cpt] = $infoEtat['nomEtat'];
					$cpt++;
				}
				
				$cpt = 0;
				$cptTable = 4;
				while(isset($Etat[$cpt]))
				{
					if($cptTable%4 == 0)
					{
						echo '<tr>';						
					}
					$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre FROM oeuvres inner join etat on oeuvres.idEtat = etat.idEtat where etat.nomEtat = :varEtat;');
					$reponseOeuvres->execute(array("varEtat" =>$Etat[$cpt]));
					if($donneeOeuvre = $reponseOeuvres->fetch())
					{

					echo '<th width="100%"> <div class="item" style="cursor:pointer; width:300px;" onClick=" window.location.href = \'oeuvres.php?etat='.$Etat[$cpt].'\'" >
                        <div class="thumbnail">
                            <img src="img/categorie/'.$donneeOeuvre['nomOeuvre'].'" alt="..." class="img-circle team-img" width="100%">
                            <div class="caption">
                                <h3>'.$Etat[$cpt].'</h3>
                            </div>
                        </div>
                    </div></th>';
					}
					$cpt++;
					$cptTable++;
				}
			
				?> 
                    </table>
           </form>
           
           
              <form id='formMedium' style='display:block;'>
                <div class="section-title center">
                    <h2>Nos <strong>Médiums</strong></h2>
                   			<br> Cliquez pour accéder aux oeuvres de ce médium.
                    <div class="line">
                        <hr>
                    </div>
                </div>
				<table width="100%">
                <?PHP
				$reponseCategorie = $Cnn->prepare('SELECT nomCategorie FROM categorie;');
				$reponseCategorie->execute();
				$cpt = 0;
				$Categorie = array();
				while($infoCategorie = $reponseCategorie->fetch())
				{
					$Categorie[$cpt] = $infoCategorie['nomCategorie'];
					$cpt++;
				}
				
				$cpt = 0;
				$cptTable = 4;
				while(isset($Categorie[$cpt]))
				{
					if($cptTable%4 == 0)
					{
						echo '<tr>';						
					}
					$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre FROM oeuvres inner join categorie on oeuvres.idCategorie = categorie.idcategorie where categorie.nomCategorie = :varCat;');
					$reponseOeuvres->execute(array("varCat" =>$Categorie[$cpt]));
					if($donneeOeuvre = $reponseOeuvres->fetch())
					{
					echo '<th width="100%"> <div class="item" style="cursor:pointer; width:300px;" onClick=" window.location.href = \'oeuvres.php?categorie='.$Categorie[$cpt].'\'" >
                        <div class="thumbnail">
                            <img src="img/categorie/'.$donneeOeuvre['nomOeuvre'].'" alt="..." class="img-circle team-img" width="100%">
                            <div class="caption">
                                <h3>'.$Categorie[$cpt].'</h3>
                            </div>
                        </div>
                    </div></th>';
					$cptTable++;
					}
					$cpt++;
				}
			
				?> 
                    </table>
               </form>
 
          	   <form id='formAnnees' style='display:none;'>
                          <div class="section-title center">
                    <h2>Nos <strong>Années</strong></h2>
                   			<br> Cliquez pour accéder aux oeuvres de cette année.
                    <div class="line">
                        <hr>
                    </div>
                </div>
				<table width="100%">
                <?PHP
				$reponseAnnee = $Cnn->prepare('SELECT DISTINCT Annee FROM Oeuvres order by Annee;');
				$reponseAnnee->execute();
				$cpt = 0;
				$Annee = array();
				while($infoAnnee = $reponseAnnee->fetch())
				{
					$Annee[$cpt] = $infoAnnee['Annee'];
					$cpt++;
				}
				
				$cpt = 0;
				$cptTable = 4;
				while(isset($Annee[$cpt]))
				{
					if($cptTable%4 == 0)
					{
						echo '<tr>';						
					}
					$reponseOeuvres = $Cnn->prepare('SELECT nomOeuvre FROM oeuvres where Annee = :varAnnee;');
					$reponseOeuvres->execute(array("varAnnee" =>$Annee[$cpt]));
					if($donneeOeuvre = $reponseOeuvres->fetch())
					{
					echo '<th width="100%"> <div class="item" style="cursor:pointer; width:300px;" onClick=" window.location.href = \'oeuvres.php?annee='.$Annee[$cpt].'\'" >
                        <div class="thumbnail">
                            <img src="img/categorie/'.$donneeOeuvre['nomOeuvre'].'" alt="..." class="img-circle team-img" width="100%">
                            <div class="caption">
                                <h3>'.$Annee[$cpt].'</h3>
                            </div>
                        </div>
                    </div></th>';
					}
					$cpt++;
					$cptTable++;
				}
			
				?> 
                    </table>
         	   </form>
            </div>
        </div>
    </div>

    <!-- Section commanditaire
    ==========================================-->
    <div id="tf-commanditaire" class="text-center">
        <div class="overlay">
            <div class="container">

                <div class="section-title center">
                    <h2>Nos <strong>Commanditaires</strong></h2>
                    <div class="line">
                        <hr>
                    </div>
                </div>
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1500px;height:600px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-oval" style="position:absolute;top:0px;left:0px;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19.0px;position:relative;top:50%;width:38px;height:38px;" src="img/oval.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative; top:0px;left:20%;width:900px;height:550px;overflow:hidden;">
        <?PHP
		$sql = 'select idCommanditaire,nomCommanditaire,pathCommanditaire from commanditaire';
		$infoCommanditaires =$Cnn->prepare($sql);
		$infoCommanditaires->execute();
		while ($infoCom = $infoCommanditaires->fetch())
		{
			echo '  <div>
                <img data-u="image" id="'.$infoCom["idCommanditaire"].'" src="img/com/'.$infoCom["pathCommanditaire"].'" title="'.$infoCom["nomCommanditaire"].'"> 
            </div>';
		}
		?>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>
    </div>
    <script type="text/javascript">jssor_1_slider_init();</script>
            </div>
        </div>
    </div>



    <!-- Contact Section
    ==========================================-->
    <div id="tf-contact" class="text-center">
        <div class="container">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <div class="section-title center">
                        <h2>Contactez-<strong>nous</strong></h2>
                        <div class="line">
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                        <small><em>Pour plus de renseignements, n'hésitez pas à nous contacter!</em></small>            
                    </div>

                    <form  name="frm_contact" id = "frm_contact" method="POST" action='sendEmail.php'>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Adresse Email</label>
                                    <input type="email" class="form-control" id="vMail" name="vMail" placeholder="Entrez votre adresse Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Message</label>
                            <textarea class="form-control" rows="3" placeholder="Entrez votre Message" id="vMessage" name="vMessage" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn tf-btn btn-default">Envoyer</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
<?php include('includes/FooterGestionnaire.php');?>
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
    <script type="text/javascript" src="js/main.js"></script>
    
    	<script>
		var mail = false;
		<?PHP if (isset($_GET['mail']) && $_GET['mail'] != NULL)
		{ ?>
		 var mail = <?PHP echo $_GET['mail'];?>;
		<?PHP
		}
		?>
	if (mail == true)
	{
		alert('Votre message a été envoyé.');
	}
        function Etats() {
			$('#formEtat').slideToggle("slow", function () {});
			 $('#formMedium').css('display', 'none');
			 $('#formAnnees').css('display', 'none');

		}
	   function Mediums() {
			$('#formMedium').slideToggle("slow", function () {});
			 $('#formEtat').css('display', 'none');
			 $('#formAnnees').css('display', 'none');

		}
		 function Annees() {
			$('#formAnnees').slideToggle("slow", function () {});
			 $('#formEtat').css('display', 'none');
			 $('#formMedium').css('display', 'none');
		}
		function Dimensions(){
			document.location.href="oeuvres.php?dimensions=true";	
		}
		function MotCle(){
			document.location.href="oeuvres.php?motcle=true";	
		}
	   
	</script>

  </body>
</html>