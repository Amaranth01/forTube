<div>
    <h2><?=$data['video']->getTitle()?></h2>

        <video controls autoplay>
            <source src="uploads/<?=$data['video']->getContent()?>">
        </video>

    <p id="infoArticle">
        Vidéo postée le <?=$data['video']->getDate()->format('d-m-Y')?> par
        <?=$data['video']->getUser()->getUsername()?>
    </p>
</div>