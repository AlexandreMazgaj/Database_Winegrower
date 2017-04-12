<html>
	<head>
	</head>

	<?php include "database.php";

		$query = pg_query("DROP SCHEMA ExpViticole CASCADE;");

		if(isset($query)){
			echo "La base de donnée a été supprimée avec succès";
		}

	?>
</html>