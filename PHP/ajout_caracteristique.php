<?php 
include "database.php";

$vins = pg_query("SELECT DISTINCT nom FROM Vin;");
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Formulaire d'ajout de caractéristique d'un vin</h1>
		<form method="post" action="ajout_be.php?t=caracteristique">
			<label>Année </label><input type="number" step="1" name="vin_annee"/><br>
			<label>Vin </label><select name="vin_nom">
				<?php while($vin = pg_fetch_row($vins))
					echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?>
			</select><br>
			<label>Caracteristique </label><input type="text" name="caracteristique"/><br>
			<label>Note </label><input type="number" min="0" max="20" step="0.1" name="note"/><br>
			<input type="submit" value="Envoyer"/>
		</form>
	</body>
</html>
