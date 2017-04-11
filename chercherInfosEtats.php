<?PHP
session_start();
include('connexionBd.php');
if (isset($_POST['selectedIndex']) && $_POST['selectedIndex'] != '')
{
	$sql ='select * from etat where nomEtat ="'.$_POST["selectedIndex"].'";';
	$infoEtats = $Cnn->prepare($sql);
	$infoEtats->execute();
	if($Etat = $infoEtats->fetch())
	{
		$arrayEtats['idetat'] = $Etat['idetat'];
		$arrayEtats['nomEtat'] = $Etat['NomEtat'];
		$arrayEtats['peuxEtreReserve'] = $Etat['peuxEtreReserve'];
		echo json_encode($arrayEtats);
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>