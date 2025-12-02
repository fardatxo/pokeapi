<?php
// Cojo el nombre de la region que me pasan por la url
$regionName = $_GET['name'];
// Saco todas las regiones para ponerlas en el menu
$regiones = json_decode(file_get_contents('https://pokeapi.co/api/v2/region/'), true);
// Saco los datos especificos de la region elegida
$regionData = json_decode(file_get_contents("https://pokeapi.co/api/v2/region/$regionName/"), true);

// Saco el primer pokedex de esa region
$pokedex = $regionData['pokedexes'][0];
$pokedexData = json_decode(file_get_contents($pokedex['url']), true);

// Cojo solo los primeros 15 pokemon para que quepan bien en el div
$pokemonEntries = array_slice($pokedexData['pokemon_entries'], 0, 13);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_PokÇmon_logo.svg.png"></header>

<nav><strong>
	<?php
	// Pongo todas las regiones como enlaces en el menu
	$generacion = 1;
	foreach ($regiones['results'] as $region) {
		echo "<a href='region.php?name={$region['name']}'>G{$generacion} {$region['name']}</a> 	";
		$generacion++;
	}
	?>
</strong></nav>

<div id="iniciales">
	<h2>Pokémon de <?= $regionName ?>:</h2>
	<?php 
	// Muestro los pokemon reales de esta region con enlaces a su info
	foreach ($pokemonEntries as $entry): ?>
		<p><a href='pokemon.php?name=<?= $entry['pokemon_species']['name'] ?>'><?= $entry['pokemon_species']['name'] ?></a></p>
	<?php endforeach; ?>
</div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>