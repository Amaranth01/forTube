<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Video;
use DateTime;

class VideoManager
{
    public static function findVideo(int $limit = 0, int $offset = 0): array {
        $video = [];

        if($limit === 0) {
            $stmt = DB::getPDO()->query("SELECT * FROM video ORDER BY id DESC LIMIT 14 OFFSET $offset");
        }

        $userManager = new UserManager();

        foreach ($stmt as $videoData) {
            $video[] = (new Video())
                ->setId($videoData['id'])
                ->setTitle($videoData['title'])
                ->setContent($videoData['video'])
                ->setDescription($videoData['description'])
                ->setImage($videoData['image'])
                ->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $videoData['date']))
                ->setUser($userManager->getUser($videoData['user_id']))
            ;
        }

        return $video;
    }

    public static function getVideo(int $id): Video {
        $stmt = DB::getPDO()->query("SELECT * FROM video WHERE id = '$id'");
        $stmt = $stmt->fetch();

        return (new Video())
            ->setId($id)
            ->setContent($stmt ['video'])
            ->setTitle($stmt['title'])
            ->setImage($stmt['image'])
            ->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $stmt['date']))
            ->setUser((new UserManager)->getUser($stmt['user_id']))
            ;
    }

    /**
     * Add an article to the DB
     * @param Video $video
     * @return bool
     */
    public static function addVideo(Video $video): bool {
        $stmt= DB::getPDO()->prepare("
            INSERT INTO video (title, video, description, image, user_id, date) 
            VALUES (:title, :video, :description, :image, :user_id, :date )
        ");

        $stmt->bindValue(':title', $video->getTitle());
        $stmt->bindValue(':video', $video->getContent());
        $stmt->bindValue(':description', $video->getDescription());
        $stmt->bindValue(':image', $video->getImage());
        $stmt->bindValue(':user_id', $video->getUser()->getId());
        $stmt->bindValue(':date', (new DateTime())->format('Y-m-d H:i:s'));

        $result = $stmt->execute();
        $video->setID(DB::getPDO()->lastInsertId());

        return $result;
    }

    /**
     * Check if the article exist
     * @param $id
     * @return int|mixed
     */
    public static function videoExist($id)
    {
        $stmt = DB::getPDO()->query("SELECT count(*) FROM video WHERE id = '$id'");
        return $stmt ? $stmt->fetch(): 0;
    }

    /**
     * update an article in DB
     * @param $newTitle
     * @param $newContent
     * @param $id
     */
    public static function updateVideo($newTitle, $newContent, $id)
    {
        $stmt = DB::getPDO()->prepare("UPDATE video 
        SET content = :newContent, title = :newTitle WHERE id = :id");

        $stmt->bindParam(':newTitle', $newTitle);
        $stmt->bindParam(':newContent', $newContent);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    /**
     * Delete an article from the DB
     * @param Video $article
     * @return false|int
     */
    public static function deleteVideo(Video $article): bool
    {
        //Check if the article exist
        if (self::videoExist($article->getId())) {
            return DB::getPDO()->exec("DELETE FROM video WHERE id = {$article->getId()} ");
        }
        return false;
    }

}