<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ForTube</title>
    <link rel="stylesheet" href="/assets/css/menu.css">
</head>
<body>
<?php

// Handling error messages.
use App\Controller\UserController;
use App\Model\Manager\UserManager;

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
    ?>
    <div class="message error">
        <?= $errors ?>
    </div> <?php
}

// Handling success messages.
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
    ?>
    <div class="message success">
        <?= $success ?>
    </div> <?php
}

var_dump($_SESSION['user']);

?>
<div id="menu">
    <h1 id="titleSite">ForTube</h1>

    <div id="category">
        <p>Catégories :</p>
        <ul>
            <li>Tous</li>
            <li>Jeux vidéos</li>
            <li>Animaux</li>
            <li>Musique</li>
            <li>Vie locale</li>
            <li>Manga / animé</li>
        </ul>
    </div>

    <div>
        <a href="/index.php?c=home&a=connexion">Connexion</a>
        <a href="/index.php?c=user&a=user-space">Espace personnel</a>
    </div>
</div>




<main class="container">
    <?= $html ?>
</main>

</body>
</html>