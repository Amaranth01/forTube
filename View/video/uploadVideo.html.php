<?php

    use App\Controller\UserController;

    if(!UserController::userConnected()) {
        $this->render('home/index');
    }

?>
<div id="contentUpload">
    <h1>Ajouter une vidéo</h1>

    <form action="/index.php?c=video&a=add-video" method="post" enctype="multipart/form-data">

        <label for="title">Nom de la vidéo</label>
        <input type="text" name="title" id="title" required>

        <label for="img">Image de couverture</label>
        <input type="file" name="img" id="img" accept=".jpg, .jepg, .png" required>

        <label for="video">Votre video</label>
        <input type="file" name="video" id="video" accept=".MP4, .MOV, .AVI" required>

        <label for="description">Résumé de la vidéo</label>
        <textarea name="description" id="description" cols="60" rows="10" maxlength="255"></textarea>

        <input type="submit" name="submit" value="Publier" class="button">
    </form>
</div>

