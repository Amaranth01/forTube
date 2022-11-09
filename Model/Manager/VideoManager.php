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
                ->setContent($videoData['content'])
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
            ->setContent($stmt ['content'])
            ->setTitle($stmt['title'])
            ->setImage($stmt['image'])
            ->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $stmt['date']))
            ->setUser((new UserManager)->getUser($stmt['user_id']))
            ;
    }

    /**
     * Count the article for pagination
     * @return mixed
     */
    public static function countVideo() {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM video");
        return $stmt->fetch()['COUNT(*)'];
    }

    /**
     * Count the article by section for the pagination
     * @param $id
     * @return mixed
     */
    public static function countArticleByCategory($id) {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM category WHERE id = $id");
        return $stmt->fetch()['COUNT(*)'];
    }

    /**
     * Add an article to the DB
     * @param Video $article
     * @return bool
     */
    public static function addArticle(Video $article): bool {
        $stmt= DB::getPDO()->prepare("
            INSERT INTO video (title, content, resume, image, user_id, category_id, date) 
            VALUES (:title, :content, :resume, :image, :user_id, :category_id, :date )
        ");

        $stmt->bindValue(':title', $article->getTitle());
        $stmt->bindValue(':content', $article->getContent());
        $stmt->bindValue(':resume', $article->getDescription());
        $stmt->bindValue(':image', $article->getImage());
        $stmt->bindValue(':user_id', $article->getUser()->getId());
        $stmt->bindValue(':section_id', $article->getCategory()->getId());
        $stmt->bindValue(':date', (new DateTime())->format('Y-m-d H:i:s'));

        $result = $stmt->execute();
        $article->setID(DB::getPDO()->lastInsertId());

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
     *
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getArticleByCategoryId(int $id, int $limit = 0, int $offset = 0 ): array
    {
        $article = [];
        if ($limit === 14) {
            $stmt = DB::getPDO()->query("SELECT * FROM video WHERE category_id = '$id' ORDER BY id DESC 
                    LIMIT 14 OFFSET $offset
            ");
        }
        $stmt = DB::getPDO()->query("SELECT * FROM video WHERE category_id = '$id' ORDER BY id DESC ");

        if($stmt) {
            foreach ($stmt->fetchAll() as $data) {
                $article [] = (new Video())
                    ->setId($data['id'])
                    ->setTitle($data['title'])
                    ->setImage($data['image'])
                    ->setDescription($data['description'])
                ;
            }
        }
        return $article;
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
    public static function deleteArticle(Video $article): bool
    {
        //Check if the article exist
        if (self::videoExist($article->getId())) {
            return DB::getPDO()->exec("DELETE FROM video WHERE id = {$article->getId()} ");
        }
        return false;
    }

    /**
     * Search an article for the search tool
     * @param $contentSearch
     * @return array
     */
    public static function searchVideo($contentSearch): array
    {
        $article = [];
        $stmt = DB::getPDO()->prepare("
            SELECT DISTINCT video.title, video.image, video.resume, video.id FROM category
                INNER JOIN video ON video = 
                video.id INNER JOIN category ON category = category.id WHERE 
                video.title LIKE '%$contentSearch%' OR category.category_name 
                LIKE '%$contentSearch%' ORDER BY id DESC 
            ");

        $stmt->execute();

        //Get the requested data in an array
        foreach ($stmt->fetchAll() as $data) {
            $article [] = (new Video())
                ->setTitle($data['title'])
                ->setDescription($data['description'])
                ->setImage($data['image'])
            ;
        }
        return $article;
    }

    /**
     * Get article after the search
     * @param $search
     * @return array
     */
    public static function getVideoBySearch($search): array
    {
        $article = [];
        $stmt = DB::getPDO()->prepare(" 
            SELECT id, title FROM video WHERE title LIKE '%$search%' ORDER BY id DESC LIMIT 6
        ");
        $stmt->execute();
        //Get the requested data in an array
        foreach ($stmt->fetchAll() as $data) {
            $article[] = [
                "id" => $data['id'],
                "title" => $data['title'],
            ];
        }
        return $article;
    }
}