<?php
// Cojo el nombre del pokemon que me pasan
$pokemonName = $_GET['name'];
// Saco la info del pokemon de la api
$pokemon = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokemonName/"), true);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pokemon - <?= $pokemonName ?></title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_PokÇmon_logo.svg.png"></header>

<nav><strong>
	<a href="index.php">Volver</a>
</strong></nav>

<div id="iniciales">
	<h2><?= $pokemon['name'] ?></h2>
	<img src="<?= $pokemon['sprites']['front_default'] ?>">
	<p>Habilidades: <?= $pokemon['abilities'][0]['ability']['name'] ?></p>
	<p>Peso: <?= $pokemon['weight'] ?></p>
	<p>Tipo: <?= $pokemon['types'][0]['type']['name'] ?></p>
</div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>