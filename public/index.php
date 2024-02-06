<?php
session_start();
require_once __DIR__ . '../../provider/Routesloader.php';
$header = require_once __DIR__ . '/components/header.php';
global $main;
if (isset($css)) {
    $css = "<link rel='stylesheet' href='css/$css.css'>";
}
else {
    $css = '';
}
if (isset($_SESSION['user_id']) and $_SERVER['REQUEST_URI'] != '/register' and $_SERVER['REQUEST_URI'] != '/login') {
    header('Location: /login');
}
?>

<DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Musicitude</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/index.css">
        <?php echo $css; ?>
    <head>
    <body class="bg-dark">
        <header>
            <?php echo $header; ?>
        </header>
        <main>
            <?php echo $main; ?>
        </main>
    </body>
</html>