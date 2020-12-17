<?php 
$data = file_get_contents('humidity.csv');

function getLastLines($string, $n = 1) {
	    $lines = explode("\n", $string);

	        $lines = array_slice($lines, -$n);
			array_pop($lines);
	        return $lines;
}

function set_trend_icon($trend) {
	if($trend > 1) {
		return '<i class="fas fa-long-arrow-alt-up text-success"></i>';
	} elseif($trend < 1) {
		return '<i class="fas fa-long-arrow-alt-down text-danger"></i>';
	}
}

$lines = getLastLines($data, 15);
$lines = array_reverse($lines);
$data = [];
foreach($lines as $row){
	$row_data = explode(',', $row);
	$row_data[6] = set_trend_icon($row_data[4]);
	$row_data[7] = set_trend_icon($row_data[5]);

	$data[] = $row_data;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/7d9a5e777c.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
<div class="container">
	<div class="row">
		<h1>DHT-22</h1>
	</div>
	<div class="row"><span class="glyphicon glyphicon-arrow-up"></span>
		<table class="table table-striped table-bordered table-hover table-dark">
		<thead class="bg-info">
			<tr>
				<td class="">Data</td>
				<td class="">Czas</td>
				<td class="">Temp.</td>
				<td class="">Wilgotność</td>
		</thead>
		<tbody>
			<?php foreach($data as $row):?>
			<tr>
				<td><?= $row[0]; ?></td>
				<td><?= $row[1]; ?></td>
				<td><?= (float) $row[2]; ?>°C <?= $row[6] ?></td>
				<td><?= $row[3]; ?> <?= $row[7] ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
</div>
</body>
</html>
