<div id="content">
    <h2>Les dernières vidéos</h2>

    <div>
        <?php
            foreach ($data['video'] as $video) { ?>
                <article>
                    <a href="/index.php?c=video&a=view-video&id=<?= $video->getId() ?>">
                        <div>
                            <img src="/uploads/<?=$video->getImage()?>" alt="Image de présentation de la vidéo">
                        </div>
                        <div>
                            <p><?=$video->getTitle()?></p>
                        </div>
                    </a>
                </article> <?php
            }?>

    </div>
</div>