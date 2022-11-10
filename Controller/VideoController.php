<?php

namespace App\Controller;


use App\Model\Entity\Video;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\VideoManager;
use Exception;

class VideoController extends AbstractController
{

    public function index()
    {
        $this->render('video/uploadVideo');
    }

    /**
     * Add an article
     */
    public function addArticle()
    {
        //Retrieves and cleans form fields
        $title = $this->clean($this->getFormField('title'));
        $description = $this->clean($this->getFormField('resume'));
        //Cleans the field and allows some tags
        $content = html_entity_decode(strip_tags($_POST['content'],'<div><p><img><h1><h2><h3><h4><h5><br><span><strong><a><em>'));

        //Checking if the writer is logged in
        $user = self::getConnectedUser();

        //Creating a new article object
        $article = (new Video())
            ->setTitle($title)
            ->setContent($content)
            ->setDescription($description)
            ->setImage($this->addImage())
            ->setUser($user)
        ;

        //Add the article
        VideoManager::addArticle($article);

        //Get categories and articles for sorting
        CategoryManager::getAllCategories();

        //Redirection to the writer's area
        $this->render('writer/writer');
    }

    /**
     * Add an image for an article
     * @return string
     */
    public function addImage(): string
    {
        $name = "";
        $error = [];
        //Checking the presence of the form field
        if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){

            //Defining allowed file types for the secured
            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];

            if(in_array($_FILES['img']['type'], $allowedMimeTypes)) {
                //Setting the maximum size
                $maxSize = 1024 * 1024;
                if ((int)$_FILES['img']['size'] <= $maxSize) {
                    //Get the temporary file name
                    $tmp_name = $_FILES['img']['tmp_name'];
                    //Assignment of the final name
                    $name = $this->getRandomName($_FILES['img']['name']);

                    //Checks if the destination file exists, otherwise it is created
                    if(!is_dir('uploads')){
                        mkdir('uploads');
                    }
                    //File move
                    move_uploaded_file($tmp_name,'../public/uploads/' . $name);
                }
                else {
                    $_SESSION['errors'] =  "Le poids est trop lourd, maximum autorisé : 1 Mo";
                    $this->render('writer/writer');
                }
            }
            else {
                $_SESSION['errors'] = "Mauvais type de fichier. Seul les formats JPG, JPEG et PNG sont acceptés";
                $this->render('writer/writer');
            }
        }
        else {
            $_SESSION['errors'] = "Une erreur s'est produite";
            $this->render('writer/writer');
        }
        $_SESSION['error'] = $error;
        return $name;
    }

    /**
     * Set a random name for the image
     * @param string $rName
     * @return string
     */
    private function getRandomName(string $rName): string
    {
        //Get file extension
        $infos = pathinfo($rName);
        try {
            //Generates a random string of 15 chars
            $bytes = random_bytes(15);
        }
        catch (Exception $e) {
            //Is used on failure
            $bytes = openssl_random_pseudo_bytes(15);
        }
        //Convert binary data to hexadecimal
        return bin2hex($bytes) . '.' . $infos['extension'];
    }

    /**
     * @param $id
     */
    public function editArticle($id)
    {
        //Checks if the writer is logged in
        if(!self::userConnected()){
            $_SESSION['errors'] = "Veuillez vous connecter pour poster une video";
            $this->render('home/index', [
                'article' => VideoManager::findVideo(4),
                'sectionTwo' => VideoManager::getVideoByCategoryId(2),
                'sectionFive' => VideoManager::getVideoByCategoryId(5),
            ]);
        }

        //Checks if the title and content fields are present
        if(!isset($_POST['title'])&& !isset($_POST['content'])) {
            $this->render('home/index', [
                'article' => VideoManager::findVideo(4),
                'sectionTwo' => VideoManager::getVideoByCategoryId(2),
                'sectionFive' => VideoManager::getVideoByCategoryId(5),
            ]);
        }
        //Cleans up data
        $newTitle = $this->clean($_POST['title']);
        $newContent = strip_tags($_POST['content'],
            '<div><p><img><h1><h2><h3><h4><h5><br><span><strong><a><em>');
        //Manager recovery
        $article= new VideoManager($newTitle, $newContent, $id);
        $article->updateVideo($newTitle, $newContent, $id);
        //Redirects to the writers page
        self::index();
    }


}