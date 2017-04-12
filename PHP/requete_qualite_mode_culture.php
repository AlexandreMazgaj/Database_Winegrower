<?php include "database.php";
$caracteristiques = pg_query("SELECT DISTINCT nom FROM Caracteristique"); ?>

<html> 
	<head> 	    
		<meta charset="utf-8"> 
	</head> 
	<body>
		<h1>Influence des modes de culture sur la qualité des vins</h1> 	        
		<form method="post" action="requete_qualite_mode_culture.php"> 				    
			<label>Critère de qualité </label><select name="critere"> 						   
				<?php while($carac = pg_fetch_row($caracteristiques)) 							        
				echo '<option value="'.$carac[0].'">'.$carac[0].'</option>'; ?> 				    
			</select></br> 
			<input type="submit" value="Envoyer"/><br/>
		</form>
		
		<?php if(isset($_POST['critere'])) {
			$params = Array($_POST['critere']);	
			$table = pg_query_params("SELECT (Exploitation.gestion_sol, Exploitation.taille), ROUND(AVG(Caracteristique.note),2) AS moyenne
				FROM Caracteristique
						INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
						INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
						INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
				WHERE Caracteristique.nom = $1
				GROUP BY (Exploitation.gestion_sol, Exploitation.taille)
				ORDER BY moyenne DESC;", $params); 	
				echo "<br><h4>Critère : ".$_POST['critere']."</h4>"; 		
				drawTable($table);
			}
		?>
	</body> 
</html>