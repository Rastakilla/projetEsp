<?php	
	$Cnn = new PDO('mysql:host=localhost;dbname=bdEsp','root','root');
	//$Cnn = new PDO('mysql:host=localhost;dbname=etu13','etu13','esvt-6652');
	$Cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$Cnn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false );
	$Cnn->query('set names UTF8');
?>