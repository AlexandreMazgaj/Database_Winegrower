<?php 
include "database.php"; 
$vins = pg_query("SELECT DISTINCT nom FROM Vin"); ?> 

<html> 
	<head> 	    
		<meta charset="utf-8"> 
	</head> 
	<body> 	        
		<h1>Influence des modes de culture sur le coût du vin</h1> 	        
		<form method="post" action="requete_finance_mode_culture.php"> 				    
			<label>Vin </label><select name="vin"> 						    
			<?php while($vin = pg_fetch_row($vins)) 							        
			echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?> 				    
			</select></br> 		    
			<input type="submit" value="Envoyer"/><br/>
		</form>             
		
		<?php if(isset($_POST['vin'])) {
			$params = Array($_POST['vin']); 		    
			$table = pg_query_params("SELECT Vin.annee, (Assemblage.pourcentage, Exploitation.parcelle) AS Parcelle, (Exploitation.gestion_sol, Exploitation.taille) AS Mode_culture, Vin.prix
			FROM Vin
			  INNER JOIN Assemblage
				ON Vin.nom=Assemblage.vin_nom AND Vin.annee=Assemblage.vin_annee
			  INNER JOIN Exploitation
				ON Exploitation.annee=Assemblage.exp_annee AND Exploitation.parcelle=Assemblage.exp_parcelle
			  WHERE Vin.nom=$1;", $params);
			echo "<br><h4>Vin: ".$_POST['vin']."</h4>"; 
			drawTable($table);
			}     
		?> 
	</body>
</html>
