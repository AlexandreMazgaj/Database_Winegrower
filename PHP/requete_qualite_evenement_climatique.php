<?php include "database.php"; 
$vins = pg_query("SELECT DISTINCT nom FROM Vin"); 
$caracteristiques = pg_query("SELECT DISTINCT nom FROM Caracteristique"); ?>

<html> 
	<head> 	    
		<meta charset="utf-8"> 
	</head> 
	<body> 	        
		<h1>Influence des événements climatiques sur la qualité des vins</h1> 	        
		<form method="post" action="requete_qualite_evenement_climatique.php"> 				    
		<label>Vin </label><select name="vin"> 						   
			<?php while($vin = pg_fetch_row($vins)) 							        
			echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?> 				    
		</select></br>     
		<label>Caractéristique </label><select name="caracteristique"> 						   
			<?php while($carac = pg_fetch_row($caracteristiques)) 							        
			echo '<option value="'.$carac[0].'">'.$carac[0].'</option>'; ?> 				    
		</select></br>  
		<input type="submit" value="Envoyer"/><br/>         
		</form>             	
		
		<?php if(isset($_POST['vin'], $_POST['caracteristique'])) {				
			$params = Array($_POST['vin'], $_POST['caracteristique']); 				
			$table = pg_query_params("SELECT Vin.annee, Caracteristique.note, Assemblage.pourcentage, EvenementClimatique.type, EvenementClimatique.intensite
				FROM Caracteristique
						INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
						INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
						INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
						INNER JOIN EvenementClimatique ON EvenementClimatique.exp_annee = Exploitation.annee AND EvenementClimatique.exp_parcelle = Exploitation.parcelle
				WHERE Vin.nom=$1 AND Caracteristique.nom=$2", $params); 	
				echo "<br><h4>Vin: ".$_POST['vin'].", caracteristique : ".$_POST['caracteristique']."</h4>"; 		
				drawTable($table);
				echo "<p><u>Note :</u> pour chaque année où le vin a été produit, ce tableau présente la note qu'il a obtenu pour la caractéristique que vous avez sélectionnée, et l'intégralité des événements climatiques ayant eu lieu sur des parcelles ayant été utilisées dans la composition finale du vin (dont le pourcentage dans l'assemblage final est affiché)</p>";
			}
		?>
	</body> 
</html>
