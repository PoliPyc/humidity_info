<?php 
$data = file_get_contents('humidity.csv');

function getLastLines($string, $n = 1) {
	    $lines = explode("\n", $string);

	        $lines = array_slice($lines, -$n);
			array_pop($lines);
	        return $lines;
}

$lines = getLastLines($data, 15);
$lines = array_reverse($lines);
$data = [];
foreach($lines as $row){
	$data[] = explode(',', $row);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-dark">
<div class="container">
	<div class="row">
		<h1>DHT-22</h1>
	</div>
	<div class="row">
		<table class="table table-stripped table-bordered table-hover table-dark">
		<thead class="bg-info">
			<tr>
				<td>Data</td>
				<td>Godzina</td>
				<td>Temperatura</td>
				<td>Wilgotność</td>
		</thead>
		<tbody>
			<?php foreach($data as $row):?>
			<tr>
				<td><?= $row[0]; ?></td>
				<td><?= $row[1]; ?></td>
				<td><?= (float) $row[2]; ?>°C</td>
				<td><?= $row[3]; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
</div>
</body>
</html>