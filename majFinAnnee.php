<?php
session_start();
include('connexionBd.php');
if (isset($_POST['security']) && $_POST['security'] == 'ok')
{
	$sql = 'update emprunt set FinAnnee = 0';
	$ReinitialiserFinAnnee = $Cnn->prepare($sql);
	$ReinitialiserFinAnnee->execute();
}
else
{
	$_SESSION['acces'] = 'non';
}

?>