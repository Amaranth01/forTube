<?php
foreach ($data['video'] as $video) { ?>

    <div>
        <a href="/index.php?c=home&a=view-video&id=<?= $video->getId() ?>">
    </div>

    <div>
        <img src="/uploads/<?= $video->getImage() ?>" alt="Image de couverture de l'article" class="artImage">

    </div>
    <div>
        <p class="artTitle"><?= $video->getTitle() ?></p></a>
        <p class="artResume"><?= $video->getDescription() ?></p>
    </div>
    <?php
}
?>