<?php 
include "database.php"; 

$cepages = pg_query("SELECT nom FROM Cepage;");
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Formulaire d'ajout de parcelle</h1>
		<form method="post" action="ajout_be.php?t=parcelle">
			<label>N° cadastre </label><input type="number" step="1" name="cadastre_pref"/><input type="text" name="cadastre_sec"/><input type="number" step="1" name="cadastre_num"/><br>
			<label>Cépage </label><select name="cepage">
				<?php while($cepage = pg_fetch_row($cepages)) 
					echo '<option value="'.$cepage[0].'">'.$cepage[0].'</option>'; ?>
			</select><br>
			<label>Exposition </label><input type="number" min="0" max="1" step="0.05" name="exposition"/><br>
			<label>Type de Sol </label><input type="text" name="type_sol"/><br>
			<label>Surface </label><input type="number" name="surface" step=".01"/><br>
			<input type="submit" value="Envoyer"/>
		</form>
	</body>
</html>
