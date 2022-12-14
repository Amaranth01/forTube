<?php

namespace App\Controller;


use App\Model\Entity\Video;
use App\Model\Manager\CommentManager;
use App\Model\Manager\VideoManager;
use Exception;

class VideoController extends AbstractController
{

    public function index()
    {
        $this->render('video/uploadVideo');
    }

    public function uploadVideo() {
        $this->render('video/uploadVideo');
    }

    public function viewVideo($id) {
        $this->render('video/viewVideo', [
            'video' => VideoManager::getVideo($id),
            'comment' => CommentManager::getCommentByArticleId($id),
        ]);
    }


    /**
     * Add an article
     */
    public function addVideo()
    {
        //Retrieves and cleans form fields
        $title = $this->clean($this->getFormField('title'));
        $description = $this->clean($this->getFormField('description'));

        //Checking if the writer is logged in
        $user = self::getConnectedUser();

        //Creating a new article object
        $video = (new Video())
            ->setTitle($title)
            ->setContent($this->addVideoContent())
            ->setDescription($description)
            ->setImage($this->addImage())
            ->setUser($user)
        ;

        //Add the article
        VideoManager::addVideo($video);

        //Redirection to user space
        $this->render('user/userSpace');
    }

    /**
     * Add an image for an article
     * @return string
     */
    public function addVideoContent(): string
    {
        $name = "";
        $error = [];
        //Checking the presence of the form field
        if(isset($_FILES['video']) && $_FILES['video']['error'] === 0){

            //Defining allowed file types for the secured
            $allowedMimeTypes = ['video/mp4', 'video/mov', 'video/avi', 'video/webm'];

            if(in_array($_FILES['video']['type'], $allowedMimeTypes)) {
                //Setting the maximum size
                if ((int)$_FILES['video']['size'] ) {
                    //Get the temporary file name
                    $tmp_name = $_FILES['video']['tmp_name'];
                    //Assignment of the final name
                    $name = $this->getRandomName($_FILES['video']['name']);

                    //Checks if the destination file exists, otherwise it is created
                    if(!is_dir('uploads')){
                        mkdir('uploads');
                    }
                    //File move
                    move_uploaded_file($tmp_name,'../public/uploads/' . $name);
                }
            }
            else {
                $_SESSION['errors'] = "Mauvais type de fichier. Seul les formats MP4, MOV, WEBM et AVI sont accept??s";
                $this->render('user/userSpace');
            }
        }
        else {
            $_SESSION['errors'] = "Une erreur s'est produite";
            $this->render('user/userSpace');
        }
        $_SESSION['error'] = $error;
        return $name;
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
                    $_SESSION['errors'] =  "Le poids est trop lourd, maximum autoris?? : 1 Mo";
                    $this->render('user/UserSpace');
                }
            }
            else {
                $_SESSION['errors'] = "Mauvais type de fichier. Seul les formats JPG, JPEG et PNG sont accept??s";
                $this->render('user/UserSpace');
            }
        }
        else {
            $_SESSION['errors'] = "Une erreur s'est produite";
            $this->render('user/UserSpace');
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
    public function editVideo($id)
    {
        //Checks if the writer is logged in
        if(!self::userConnected()){
            $_SESSION['errors'] = "Veuillez vous connecter pour poster une video";
            $this->render('home/index', [
                'video' => VideoManager::findVideo(4),
            ]);
        }

        //Checks if the title and content fields are present
        if(!isset($_POST['title'])&& !isset($_POST['content'])) {
            $this->render('home/index', [
                'video' => VideoManager::findVideo(4),
            ]);
        }
        //Cleans up data
        $newTitle = $this->clean($_POST['title']);
        $newContent = strip_tags($_POST['content'],
            '<div><p><img><h1><h2><h3><h4><h5><br><span><strong><a><em>');
        //Manager recovery
        $video= new VideoManager($newTitle, $newContent, $id);
        $video->updateVideo($newTitle, $newContent, $id);
        //Redirects to the writers page
        self::index();
    }

    /**
     * @param int $id
     */
    public function deleteArticle(int $id)
    {
        //Verify if a user is connected
        if(!isset($_SESSION['user'])) {
            $_SESSION['errors'] = "Seul un r??dacteur peut supprimer un article";
            $this->render('home/index', [
                'video' => VideoManager::findVideo(),
            ]);
        }
        //verify who is connected
        if($_SESSION['user']->getRole()->getRoleName() === 'user') {
            $_SESSION['errors'] = "Seul l'utilisateur propri??taire de la video peut la supprimer";
            $this->render('home/index', [
                'video' => VideoManager::findVideo(),
            ]);
        }
        if (self::userConnected()) {
            //Check that the video exists
            if(VideoManager::VideoExist($id)) {
                $video = VideoManager::getVideo($id);
                $deleted = VideoManager::deleteVideo($video);
                $this->render('writer/writer');
            }
        }
    }
}