<?php
try
	{	
	$Cnn = new PDO('mysql:host=localhost;dbname=bdesp','root','root');
	$Cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$Cnn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false );
	}
catch (PDOException $error)
	{
		echo 'Erreur :' .$error->getMessage();
	}
?>