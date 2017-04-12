<?php 
include "database.php"; 
$vins = pg_query("SELECT DISTINCT nom FROM Vin"); ?>
 
<html> 
	<head> 	    
		<meta charset="utf-8"> 
	</head> 
	<body> 	        
		<h1>Influence des modes de culture sur la quantité vendue</h1> 	        
		<form method="post" action="requete_qualite_mode_culture_quantite.php"> 				    
			<label>Vin </label><select name="vin"> 						    
			<?php while($vin = pg_fetch_row($vins)) 							        
			echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?> 				    
			</select></br> 		    
			<input type="submit" value="Envoyer"/><br/>
		</form>             
		
		<?php if(isset($_POST['vin'])) { 		    
			$params = Array($_POST['vin']); 		    
			$table = pg_query_params("SELECT Vin.annee, Assemblage.pourcentage, (Exploitation.gestion_sol, Exploitation.taille) AS Mode_culture, Vin.quantite
			FROM Vin
			  INNER JOIN Assemblage
				ON Vin.nom=Assemblage.vin_nom AND Vin.annee=Assemblage.vin_annee
			  INNER JOIN Exploitation
				ON Exploitation.annee=Assemblage.exp_annee AND Exploitation.parcelle=Assemblage.exp_parcelle
			  WHERE Vin.nom=$1
			  ORDER BY Vin.quantite DESC;", $params); 
			echo "<br><h4>Vin: ".$_POST['vin']."</h4>"; 
			drawTable($table);
			}
		?> 
	</body>
</html>
