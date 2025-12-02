<?php
$pokemon = null;

if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
    $pokemon = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $_GET['nombre']);
    $pokemon = json_decode($pokemon, true);
}

if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
    $tipo = file_get_contents("https://pokeapi.co/api/v2/type/" . $_GET['tipo']);
    $tipo = json_decode($tipo, true);
    if (isset($tipo['pokemon'][0])) {
        $pokemon = file_get_contents($tipo['pokemon'][0]['pokemon']['url']);
        $pokemon = json_decode($pokemon, true);
    }
}

if (isset($_GET['region']) && !empty($_GET['region'])) {
    $region = file_get_contents("https://pokeapi.co/api/v2/region/" . $_GET['region']);
    $region = json_decode($region, true);
    if (isset($region['pokedexes'][0])) {
        $pokedex = file_get_contents($region['pokedexes'][0]['url']);
        $pokedex = json_decode($pokedex, true);
        if (isset($pokedex['pokemon_entries'][0])) {
            $pokemon = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $pokedex['pokemon_entries'][0]['pokemon_species']['name']);
            $pokemon = json_decode($pokemon, true);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Búsqueda Pokemon</title>
    <link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>

<header> Mi blog de &nbsp;&nbsp; <img src="img/International_PokÇmon_logo.svg.png"></header>

<nav><strong>
    <a href="index.php">Inicio</a>
</strong></nav>

<div id="iniciales">
    <div style="padding: 20px;">
        <h2>Buscar Pokémon</h2>
        
        <form method="GET">
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="tipo" placeholder="Tipo">
            <input type="text" name="region" placeholder="Región">
            <button type="submit">Buscar</button>
        </form>

        <?php if (isset($pokemon)): ?>
            <h3><?= $pokemon['name'] ?></h3>
            <img src="<?= $pokemon['sprites']['front_default'] ?>">
            <p>Peso: <?= $pokemon['weight'] ?></p>
            <p>Altura: <?= $pokemon['height'] ?></p>
        <?php endif; ?>
    </div>
</div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>