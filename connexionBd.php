<?php	
	$Cnn = new PDO('mysql:host=localhost;dbname=bdEsp','root','root');
	$Cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$Cnn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false );
	$Cnn->query('set names UTF8');
?>