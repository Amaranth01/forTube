<div id="content">
    <div >
        <?php
            foreach ($data['video'] as $video) { ?>
                <article id="contentArticle">
                    <h2>
                        <p><?=$video->getTitle()?></p>
                    </h2>
                    <a href="/index.php?c=video&a=view-video&id=<?= $video->getId() ?>">
                        <div>
                            <img src="/uploads/<?=$video->getImage()?>" alt="Image de présentation de la vidéo">
                        </div>
                    </a>
                    <p class="videoResume"><?= $video->getDescription() ?></p>
                </article> <?php
            }?>

    </div>
</div>