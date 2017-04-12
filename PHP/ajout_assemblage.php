<?php 
	include "database.php";
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Formulaire d'ajout des assemblages</h1>
		<?php if(!isset($_POST['num'])) { 
			$vins = pg_query("SELECT DISTINCT nom FROM Vin;"); ?>
			<form method="post" action="ajout_assemblage.php">
				<label>Nom Vin </label><select name="vin_nom">
					<?php while($vin = pg_fetch_row($vins))
						echo '<option value="'.$vin[0].'">'.$vin[0].'</option>'; ?>
				</select><br>
				<label>Année Vin </label><input type="number" name="vin_annee"/><br>
				<label>Nombre d'exploitations qui composent ce vin </label><input type="number" name="num"/><br>
				<input type="submit" value="Envoyer"/><br/>
			</form>
		<?php } else { 
			$parcelles = pg_fetch_all_columns(pg_query("SELECT cadastre FROM Parcelle WHERE exist=true;")); ?>
			<form method="post" action="ajout_be.php?t=assemblage">
				<input type="hidden" name="vin_nom" value="<?php echo $_POST['vin_nom']; ?>" />
				<input type="hidden" name="vin_annee" value="<?php echo $_POST['vin_annee']; ?>" />
				<input type="hidden" name="num" value="<?php echo $_POST['num']; ?>" />
				<?php for($i=1; $i <= $_POST['num']; $i++) { ?>
					<strong>Exploitation n°<?php echo $i; ?></strong><br>
					<label>Année d'exploitation </label><input type="number" name="exp_annee<?php echo $i; ?>"/><br>
					<label>Parcelle </label><select name="exp_parcelle<?php echo $i; ?>">
						<?php foreach($parcelles as $parcelle)
							echo '<option value="'.$parcelle.'">'.$parcelle.'</option>'; ?>
					</select><br>
					<label>Pourcentage </label><input type="number" max="1" min="0" step="0.01" name="pourcentage<?php echo $i; ?>"/><br>
				<?php } ?>
				<input type="submit" value="Envoyer"/><br>
			</form>
		<?php } ?>
	</body>
</html>
