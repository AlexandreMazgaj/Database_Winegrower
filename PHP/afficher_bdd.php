<?php include "database.php"; ?>

<html>
	<head> 	
		<meta charset="utf-8"> 
	</head> 
	<body> 	
		<h1>Cepage</h1> 	
		<?php drawTable(pg_query("SELECT * FROM Cepage")); ?>
		<h1>Parcelle</h1>
		<?php drawTable(pg_query("SELECT * FROM Parcelle")); ?>
		<h1>Exploitation</h1>
		<?php drawTable(pg_query("SELECT * FROM Exploitation")); ?>
		<h1>Vin</h1>
		<?php drawTable(pg_query("SELECT * FROM Vin")); ?>
		<h1>Assemblage</h1>
		<?php drawTable(pg_query("SELECT * FROM Assemblage")); ?>
		<h1>ApplicationTraitement</h1>
		<?php drawTable(pg_query("SELECT * FROM ApplicationTraitement")); ?>
		<h1>EvenementClimatique</h1>
		<?php drawTable(pg_query("SELECT * FROM EvenementClimatique")); ?>
		<h1>Caracteristique</h1>
		<?php drawTable(pg_query("SELECT * FROM Caracteristique")); ?>
	</body>
</html>
