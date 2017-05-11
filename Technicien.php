<!DOCTYPE html>
<html lang="en">
  <head>
    <?PHP
	session_start();
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
	<?PHP
	include_once('includes/HeaderOeuvres.php'); 
	if (isset($_SESSION['email']) && isset($_SESSION['mdp']))
	{
		$sql = 'select nomVariable,value from variable';
		$infoVariable = $Cnn->prepare($sql);
		$infoVariable->execute();
		$from;
		$mdp;
		$host;
		$port;
		while($Variable = $infoVariable->fetch())
		{
			if($Variable['nomVariable'] == 'Username')
			{
				$from = $Variable['value'];
			}
			else if ($Variable['nomVariable'] == 'Port')
			{
				$port = $Variable['value'];
			}
			else if ($Variable['nomVariable'] == 'Host')
			{
				$host= $Variable['value'];
			}
			else if ($Variable['nomVariable'] == 'Password')
			{
				$mdp = $Variable['value'];
			}
		}
	?>

    <!-- Oeuvres
    ==========================================-->
    <div id="tf-verif" class="text-center">
        <div class="overlay">
            <div class="content">
                              <form id="gestionnaire" action="modifierServeur.php" method="POST">
                     <div align="center"> From
                                    <input class="form-control-little" id="from" required name="from" placeholder="Entrez le nouveau from" value="<?PHP echo $from;?>"></input>
                                     Mot de Passe
                                    <input class="form-control-little" id="mdp" required name="mdp" placeholder="Entrez le nouveau mot de passe"  value="<?PHP echo $mdp;?>"></input>
                                      Host
                                    <input class="form-control-little" id="host" required name="host" placeholder="Entrez le nouveau host"  value="<?PHP echo $host;?>"></input>
                                      Port
                                    <input  class="form-control-little" type="number" required id="port" name="port" placeholder="Entrez le nouveau port"  value="<?PHP echo $port;?>"></input><br>
                   		 <button type="submit" class="btn tf-btn btn-notdefault">Modifier</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
                  	<?PHP 
	}
	else
	{
		$_SESSION['acces'] = 'non';
		header('location:index.php');
	}
	include('includes/Footer.php'); ?>
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
  </body>
</html>