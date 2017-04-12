<?php include "database.php"; 
$caracteristiques = pg_query("SELECT DISTINCT nom FROM Caracteristique"); 
?>

<html>
	<head> 	
		<meta charset="utf-8"> 
	</head> 
	<body> 	
		<h1>Influence de l'utilisation de cépages sur la qualité</h1> 	
		<form method="post" action="requete_cepage_caracteristique.php"> 		
			<label>Caracteristique </label><select name="caracteristique"> 			
				<?php while($caracteristique = pg_fetch_row($caracteristiques)) 				
				echo '<option value="'.$caracteristique[0].'">'.$caracteristique[0].'</option>'; ?> 		
			</select></br>
			<label>Seuil </label><input type="number" value="0.5" min="0" max="1" step="0.01" name="seuil" /><br>
			Un vin contenant un pourcentage d'un cépage inférieur à ce seuil ne sera pas utilisé pour le calcul de la note de ce cépage<br>
			<input type="submit" value="Envoyer"/><br/>
		</form>
		
		<?php if(isset($_POST['caracteristique'])) {
			$params = Array($_POST['caracteristique'], $_POST['seuil']);
			$table = pg_query_params("SELECT AssemblageEnCepage.cepage, ROUND(AVG(Caracteristique.note), 2) AS moyenne, COUNT(Caracteristique.note) AS nbre_vins_l_utilisant
				FROM (SELECT (Assemblage.vin_nom, Assemblage.vin_annee) AS vin, Parcelle.cepage AS cepage , SUM(Assemblage.pourcentage) AS pourcentage
							FROM Parcelle
								INNER JOIN Exploitation ON Exploitation.parcelle = Parcelle.cadastre
								INNER JOIN Assemblage ON Assemblage.exp_annee = Exploitation.annee AND Assemblage.exp_parcelle = Exploitation.parcelle
							GROUP BY Parcelle.cepage, (Assemblage.vin_nom, Assemblage.vin_annee)
						) AS AssemblageEnCepage
					INNER JOIN Vin ON (Vin.nom, Vin.annee) = AssemblageEnCepage.vin
					INNER JOIN Caracteristique ON (Caracteristique.vin_nom, Caracteristique.vin_annee) = AssemblageEnCepage.vin
				WHERE Caracteristique.nom = $1 AND AssemblageEnCepage.pourcentage > $2 GROUP BY AssemblageEnCepage.cepage
				ORDER BY moyenne DESC
			;", $params);
			echo "<br><h4>Caracteristique: ".$_POST['caracteristique'].", Seuil: ".$_POST['seuil']."</h4>";
			drawTable($table);
		} ?>
	</body>
</html>
