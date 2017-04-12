<?php 
include "database.php"; 

$parcelles = pg_query("SELECT cadastre FROM Parcelle WHERE exist=true;");
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Formulaire d'ajout d'un événement climatique</h1>
		<form method="post" action="ajout_be.php?t=evtclimatique">
			<label>Parcelle </label><select name="exp_parcelle">
				<?php while($parcelle = pg_fetch_row($parcelles))
					echo '<option value="'.$parcelle[0].'">'.$parcelle[0].'</option>'; ?>
			</select><br>
			<label>Type d'événement </label><input type="text" name="type"/><br/>
			<label>Intensité </label><input type="number" min="0" max="10" step="0.01" name="intensite"/><br/>
			<label>Date </label><input type="date" name="date"/> La date doit-être écrite au format année-mois-jour<br>
			<input type="submit" value="Envoyer"/><br/>
		</form>
	</body>
</html>
