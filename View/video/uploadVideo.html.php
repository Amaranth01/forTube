<?php
//
//    use App\Controller\UserController;
//
//    if(!UserController::userConnected()) {
//        $this->render('home/index');
//    }
//
//?>

<h1>Ajouter une vidéo</h1>

<form action="/index.php?c=video&a=add-video" method="post" enctype="multipart/form-data">

    <label for="img">Image de couverture</label>
    <input type="file" name="img" id="img" accept=".jpg, .jepg, .png" required>

    <label for="title">Nom de la vidéo</label>
    <input type="text" name="title" id="title" required>

    <label for="video">Votre video</label>
    <input type="file" name="video" id="video" accept=".MP4, .MOV, .AVI" required>

    <label for="description">Résumé de la vidéo</label>
    <textarea name="description" id="description" cols="60" rows="10" maxlength="255"></textarea>

    <div id="section">
        <p>Les catégories</p>

        <label for="animaux">Animaux</label>
        <input type="checkbox" name="category" id="animaux" value="Animaux">

        <label for="jeuxVideo">Jeux video</label>
        <input type="checkbox" name="category" id="jeuxVideo" value="Jeux video">

        <label for="local">Vie locale</label>
        <input type="checkbox" name="category" id="local" value="Vie locale">

        <label for="musique">Musique</label>
        <input type="checkbox" name="category" id="musique" value="musique">

        <label for="manga">Manga / animé</label>
        <input type="checkbox" name="category" id="manga" value="manga">
    </div>

    <input type="submit" name="submit" value="Publier" class="button">
</form>
