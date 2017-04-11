<?PHP
session_start();
include('connexionBd.php');
if (isset($_POST['selectedIndex']) && $_POST['selectedIndex'] != '')
{
	$sql ='select * from categorie where nomCategorie ="'.$_POST['selectedIndex'].'";';
	$infoCategorie = $Cnn->prepare($sql);
	$infoCategorie->execute();
	if($categorie = $infoCategorie->fetch())
	{
		$arrayCategorie['idCategorie'] = $categorie['idCategorie'];
		$arrayCategorie['nomCategorie'] = $categorie['nomCategorie'];
		echo json_encode($arrayCategorie);
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>