<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ForTube</title>
    <link rel="stylesheet" href="/assets/css/style.css">
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
?>
    <h1 id="TitleSite">ForTube</h1>

    <div>
        <label for="search"></label>
        <input type="search" id="search" name="search" placeholder="rechercher">

        <img src="" alt="">
    </div>
    

    <div id="category">
        <p>Catégories :</p>
        <ul>
           <li>Tous</li>
            <li>Jeux vidéos</li>
            <li>Animaux</li>
            <li>Musique</li>
            <li>Vie locale</li>
        </ul>
    </div>

<main class="container">
    <?= $html ?>
</main>

</body>
</html>