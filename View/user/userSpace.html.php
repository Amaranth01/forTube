<div id="titleUser">
    <h2>Bienvenue dans votre espace personnel</h2>
</div>

<div id="userSpace">
    <h3>Vos vidéos</h3>
    <p>
        Vous pouvez <a href="/index.php?c=video&a=upload-video">Upload de nouvelles vidéos</a>
    </p>
    <div id="contentUserSpace">
        <?php
        foreach ($data['video'] as $video) { ?>
            <article id="contentArticleUserSpace">
                <h2>
                    <p><?=$video->getTitle()?></p>
                </h2>
                <a href="/index.php?c=video&a=view-video&id=<?= $video->getId() ?>">
                    <div>
                        <img src="/uploads/<?=$video->getImage()?>" alt="Image de présentation de la vidéo">
                    </div>
                </a>
            </article> <?php
        }?>

    </div>

</div>