<?php
$db = pg_connect("host=tuxa.sme.utc dbname=dbnf17p077 user=nf17p077 password=CieCi5Kx");
if(!$db) {
	echo "Erreur de connection à la DB !!";
	die;
}
pg_query("SET search_path TO expviticole;");

//Dessine une table retourné par pg_query_params
function drawTable($table) {
?>
	<table border="1" style="border-collapse: collapse;">
		<tr>
			<?php for($i = 0; $i < pg_num_fields($table); $i++) echo "<th>".pg_field_name($table, $i)."</th>"; ?>
		</tr>
		<?php while($row = pg_fetch_row($table)) { ?>
		<tr>
			<?php foreach($row as $data) echo "<td>".$data."</td>"; ?>
		</tr>
		<?php } ?>
	</table>
<?php
}
?>
