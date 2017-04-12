<?php
include "database.php";

switch($_GET['t']) {
case "cepage":
	$params = array($_POST['nom'], $_POST['couleur']);
	$res = pg_query_params("INSERT INTO Cepage (nom, couleur) VALUES ($1, $2);", $params);
	break;
case "parcelle":
	$params = array($_POST['cadastre_pref'], $_POST['cadastre_sec'], $_POST['cadastre_num'], $_POST['cepage'], $_POST['exposition'], $_POST['type_sol'], $_POST['surface']);
	$res = pg_query_params("INSERT INTO Parcelle (cadastre, cepage, exist, exposition, type_sol, surface) VALUES (($1, $2, $3), $4, true, $5, $6, $7);", $params);
	break;
case "exploitation":
	$params = array($_POST['annee'], $_POST['parcelle'], $_POST['gestion_sol'], $_POST['taille']);
	$res = pg_query_params("INSERT INTO Exploitation (annee, parcelle, gestion_sol, taille) VALUES ($1, $2, $3, $4);", $params);
	break;
case "traitement":
	$params = array($_POST['date'], $_POST['traitement'], $_POST['exp_parcelle']);
	$annee = explode("-",$params[0]);
	$params[3] = $annee[0];
	$res = pg_query_params("INSERT INTO ApplicationTraitement (date, traitement, exp_annee, exp_parcelle) VALUES ($1, $2, $4, $3);", $params);
	break;
case "vin":
	$params = array($_POST['nom'], $_POST['annee'], $_POST['prix'], $_POST['quantite']);
    $res = pg_query_params("INSERT INTO Vin (nom, annee, prix, quantite) VALUES ($1, $2, $3, $4);", $params);
    break;
case "evtclimatique":
	$params = array($_POST['exp_parcelle'], $_POST['type'], $_POST['intensite'], $_POST['date']);
	$annee = explode("-",$params[3]);
	$params[4] = $annee[0];
    $res = pg_query_params("INSERT INTO EvenementClimatique (exp_annee, exp_parcelle, type, intensite, date) VALUES ($5, $1, $2, $3, $4);", $params);
    break;
case "caracteristique":
	$params = array($_POST['vin_annee'], $_POST['vin_nom'], $_POST['caracteristique'], $_POST['note']);
	$res = pg_query_params("INSERT INTO Caracteristique (vin_annee, vin_nom, nom, note) VALUES ($1, $2, $3, $4);", $params);
	break;
case "assemblage":
	$requete = "INSERT INTO Assemblage (vin_annee, vin_nom, exp_annee, exp_parcelle, pourcentage) VALUES ";
	for($i = 3; $i <= $_POST['num']*3+2;) {
		if($i != 3) $requete .= ", ";
		$requete .= "($1, $2, $".$i++.", $".$i++.", $".$i++.")";
	}
	$requete .= ";";
	
	$params = array();
	array_push($params, $_POST['vin_annee'], $_POST['vin_nom']);
	for($i = 1; $i <= $_POST['num']; $i++) 
		array_push($params, $_POST['exp_annee'.$i], $_POST['exp_parcelle'.$i], $_POST['pourcentage'.$i]);
	
	$res = pg_query_params($requete, $params);
	break;
default:
	echo "Erreur: mauvais t !";
	die;
}

if(!$res) {
	echo "Erreur de la requete SQL";
	die;
}
else
	echo "Done !";
?>
