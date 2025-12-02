<?php
	//CONEXIONES A LA API
	$api = file_get_contents('https://pokeapi.co/api/v2/');
		$main = json_decode($api, true);
	$region = file_get_contents('https://pokeapi.co/api/v2/region/');
		$regiones = json_decode($region, true);
	$pokemons = file_get_contents('https://pokeapi.co/api/v2/pokemon/');
		$poke = json_decode($pokemons, true);
	$poked = file_get_contents('https://pokeapi.co/api/v2/pokedex/');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_PokÇmon_logo.svg.png"></header>

<div></div>

<nav><strong>
	<?php
	// Mostrar regiones
	$generacion = 1;
	foreach ($regiones['results'] as $region) {
		echo "<a href='region.php?name={$region['name']}'>G{$generacion} {$region['name']}</a> 	";
		$generacion++;
	}
	echo "<a href='buscar.php'>Busqueda</a>";
	?>
</strong> </nav>

<div id="iniciales">
	<?php



	?>
</div>

<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>

