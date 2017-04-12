<?php include "database.php"; 
$vins = pg_query("SELECT DISTINCT nom FROM Vin"); 
$traitements = pg_query("SELECT DISTINCT traitement FROM Applicationtraitement");
?> 
<html> 
	<head> 	        
		<meta charset="utf-8"> 
	</head> 
	<body> 	            
		<h1>Influence financière des traitements phytosanitaires</h1> 	            
		<form method="post" action="requete_finance_traitement.php">
			<label>Traitement </label><select name="traitement">
				<?php while($trait = pg_fetch_row($traitements))
				echo '<option value="'.$trait[0].'">'.$trait[0].'</option>'; ?>
			</select></br> 				        
			<label>Vin </label><select name="vin"> 						        
			<?php while($vin = pg_fetch_row($vins)) 							            
				echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?> 				       
			</select></br>
			<input type="submit" value="Envoyer"/><br/>
		</form>                 
		
		<?php if(isset($_POST['traitement'], $_POST['vin'])) { 		    
			$params = Array($_POST['traitement'], $_POST['vin']); 		    
			$table = pg_query_params("SELECT (Vin.nom, Vin.annee), Vin.prix*Vin.quantite AS Chiffre_d_affaire, COUNT(Applicationtraitement.traitement) AS Nbre_Utilisations FROM Vin
				INNER JOIN Assemblage ON Assemblage.vin_nom = Vin.nom AND Assemblage.vin_annee = Vin.annee
				INNER JOIN Exploitation ON Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
				INNER JOIN  Applicationtraitement ON Exploitation.annee = Applicationtraitement.exp_annee AND Exploitation.parcelle = Applicationtraitement.exp_parcelle
				WHERE Applicationtraitement.traitement = $1 AND Vin.nom = $2 GROUP BY Vin.nom, Vin.annee,Applicationtraitement.traitement;", $params);     
			echo "<br><h4>Traitement: ".$_POST['traitement'].", vin: ".$_POST['vin']."</h4>"; 
			drawTable($table);
			}
		?> 
	</body>
</html>
