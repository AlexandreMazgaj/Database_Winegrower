<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Formulaire d'ajout de vin</h1>
		<form method="post" action="ajout_be.php?t=vin">
			<label>Nom </label><input type="text" name="nom"/><br/><br/>
			<label>Année </label><input type="text" name="annee"/><br/><br/>
			<label>Prix </label><input type="number" min="0" name="prix" step=".01"/><br/><br/>
			<label>Quantité </label><input type="number" min="1" step="1" name="quantite"/><br/><br/>
			<input type="submit" value="Envoyer"/><br/><br/>
		</form>
	</body>
</html>
