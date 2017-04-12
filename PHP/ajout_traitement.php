<?php 
include "database.php"; 

$parcelles = pg_query("SELECT * FROM Parcelle WHERE exist=true;");
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Formulaire d'ajout d'un traitement</h1>
		<form method="post" action="ajout_be.php?t=traitement">
			<label>Date </label><input type="date" name="date"/> La date doit-être écrite au format année-mois-jour<br>
			<label>Nom Traitement </label><input type="text" name="traitement"/><br/>
			<label>Parcelle </label><select name="exp_parcelle">
				<?php while($parcelle = pg_fetch_row($parcelles))
					echo '<option value="'.$parcelle[0].'">'.$parcelle[0].'</option>'; ?>
			</select><br>
			<input type="submit" value="Envoyer"/><br/>
		</form>
	</body>
</html>
