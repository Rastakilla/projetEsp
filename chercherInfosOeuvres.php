<?PHP
session_start();
include('connexionBd.php');
if (isset($_POST['selectedIndex']) && $_POST['selectedIndex'] != '')
{
	$sql ='select idOeuvres,nomOeuvre,Auteur,Hauteur,Largeur,Profondeur,Titre,Annee,lieu,description,nomCategorie,NomEtat from oeuvres inner join categorie on oeuvres.idCategorie = categorie.idCategorie inner join etat on oeuvres.idEtat = etat.idetat where Titre ="'.$_POST['selectedIndex'].'";';
	$infoOeuvres = $Cnn->prepare($sql);
	$infoOeuvres->execute();
	if($oeuvre = $infoOeuvres->fetch())
	{
		$arrayOeuvres['idOeuvres'] = $oeuvre['idOeuvres'];
		$arrayOeuvres['Auteur'] = $oeuvre['Auteur'];
		$arrayOeuvres['Hauteur'] = $oeuvre['Hauteur'];
		$arrayOeuvres['Largeur'] = $oeuvre['Largeur'];
		$arrayOeuvres['Profondeur'] = $oeuvre['Profondeur'];
		$arrayOeuvres['Titre'] = $oeuvre['Titre'];
		$arrayOeuvres['Annee'] = $oeuvre['Annee'];
		$arrayOeuvres['lieu'] = $oeuvre['lieu'];
		$arrayOeuvres['description'] = $oeuvre['description'];
		$arrayOeuvres['nomCategorie'] = $oeuvre['nomCategorie'];
		$arrayOeuvres['NomEtat'] = $oeuvre['NomEtat'];
		echo json_encode($arrayOeuvres);
	}
}
else
{
	$_SESSION['acces'] = 'non';
	header('location:index.php');
}
?>