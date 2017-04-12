<?php 
	include "database.php"; 
	$vins = pg_query("SELECT DISTINCT nom FROM Vin"); 
	$caracteristiques = pg_query("SELECT DISTINCT nom FROM Caracteristique");
	$traitements = pg_query("SELECT DISTINCT traitement FROM Applicationtraitement");
?>

<html> 
	<head> 	        
		<meta charset="utf-8"> 
	</head> 
	<body> 	            
		<h1>Influence écologique des traitements phytosanitaires</h1> 	            
		<form method="post" action="requete_ecologique_traitement.php">
			<label>Traitement </label><select name="traitement">
				<?php while($trait = pg_fetch_row($traitements))
				echo '<option value="'.$trait[0].'">'.$trait[0].'</option>'; ?>
			</select></br> 				        
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
		
		<?php if(isset($_POST['traitement'], $_POST['vin'], $_POST['caracteristique'])) { 		    
			$params = Array($_POST['traitement'], $_POST['vin'], $_POST['caracteristique']); 		    
			$table = pg_query_params("SELECT Vin.annee, Applicationtraitement.traitement, Caracteristique.nom, Caracteristique.note, COUNT(Applicationtraitement.traitement) FROM Vin
		INNER JOIN Caracteristique ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
		INNER JOIN Assemblage ON Assemblage.vin_nom = Vin.nom AND Assemblage.vin_annee = Vin.annee
		INNER JOIN Exploitation ON Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
		INNER JOIN  Applicationtraitement ON Exploitation.annee = Applicationtraitement.exp_annee AND Exploitation.parcelle = Applicationtraitement.exp_parcelle
		WHERE Applicationtraitement.traitement = $1 AND Vin.nom = $2 AND Caracteristique.nom = $3
		GROUP BY Vin.annee, Caracteristique.nom, Caracteristique.note, Applicationtraitement.traitement;", $params);
			echo "<br><h4>Traitement: ".$_POST['traitement'].", vin: ".$_POST['vin'].", caracteristique: ".$_POST['caracteristique']."</h4>"; 
			drawTable($table);}     
		?> 
	</body>
</html>
