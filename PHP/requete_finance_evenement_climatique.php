<?php 
include "database.php"; 
$vins = pg_query("SELECT DISTINCT nom FROM Vin");
?> 

<html> 
	<head> 	
		<meta charset="utf-8"> 
	</head> 
	<body> 	    
		<h1>Influence des événements climatiques sur les revenus</h1> 	    
		<form method="post" action="requete_finance_evenement_climatique.php"> 				
			<label>Vin </label><select name="vin"> 						
			<?php while($vin = pg_fetch_row($vins)) 							
				echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?> 				
			</select></br>
			<input type="submit" value="Envoyer"/><br/>
		</form>         
		
		<?php if(isset($_POST['vin'])) {		
			$params = Array($_POST['vin']); 		
			$table = pg_query_params("SELECT Vin.annee, Vin.prix*Vin.quantite AS chiffre_affaire, EvtSurVin.date, EvtSurVin.type, EvtSurVin.intensite, EvtSurVin.pourcentage
				FROM Vin
					LEFT JOIN (SELECT (Assemblage.vin_nom, Assemblage.vin_annee) AS vin, EvenementClimatique.date, EvenementClimatique.type, EvenementClimatique.intensite, Assemblage.pourcentage
									FROM EvenementClimatique
										INNER JOIN Exploitation ON EvenementClimatique.exp_parcelle=Exploitation.parcelle AND EvenementClimatique.exp_annee=Exploitation.annee
										INNER JOIN Assemblage ON Assemblage.exp_annee=Exploitation.annee AND Assemblage.exp_parcelle=Exploitation.parcelle
								) AS EvtSurVin ON EvtSurVin.vin = (Vin.nom, vin.annee)
				WHERE Vin.nom = $1 ORDER BY Vin.annee
			;", $params);
			echo "<br><h4>Vin: ".$_POST['vin']."</h4>";
			echo "<p>Veuillez noter que dans le cas où une ligne est vide, cela signifie que le vin n'a été touché par aucun événement climatique</p>";
			drawTable($table); 
		} ?>
	</body> 
</html>

