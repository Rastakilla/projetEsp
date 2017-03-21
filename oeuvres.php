<!DOCTYPE html>
<html lang="en">
  <head>
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
  </head>
  <body onload ="menu();">
   <?PHP
		if (isset($_GET['categorie']) && $_GET['categorie']!=NULL)
		{
			$medium = htmlentities($_GET['categorie']);
		}
		else
		{
			header('Location: index.php');
		}
		?>
	<?PHP include('includes/HeaderOeuvres.php'); ?>

    <!-- Oeuvres
    ==========================================-->
    <div id="tf-oeuvres" class="text-center"  style='width:100%';>
        <div class="overlay"  style='width:100%';>
                <?PHP
				$directory = "img/categorie/".$medium;
				$files = scandir($directory);
				$num_files = count($files)-2;
				$cptInit = 0;
				$contour = '#80f442';//aller chercher dans la bd plus tard
				echo '<h2><strong>'.$medium.'</strong></h2>';
				while($cptInit < $num_files)
				{
					echo '<br><img src="img/categorie/'.$medium.'/'.$medium.$cptInit.'.jpg" width="30%" height="30%" onmouseover="" style="cursor: pointer;	border: 2px solid '.$contour.'" ';		
					$cptInit++;			
				}
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

    <!-- Javascripts
    ================================================== -->
    <script>
	function menu(){
	 $('.navbar-default').addClass('on');
	}
	</script>

  </body>
  <?php include('includes/Footer.php');?>
</html>