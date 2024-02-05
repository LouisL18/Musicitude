<?php
require_once __DIR__ . '../../provider/Routesloader.php';
$header = require_once __DIR__  . '../components/header.php';
global $main;
?>

<DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Musicitude</title>
    <head>
    <body>
        <header>
            <?php echo $header; ?>
        </header>
        <main>
            <?php echo $main; ?>
        </main>
    </body>
</html>
