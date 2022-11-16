<?php

namespace App\Controller;


use App\Model\Manager\VideoManager;

class HomeController extends AbstractController
{
    public function index() {
        $this->render('home/index', [
            'video' => VideoManager::findVideo(0),
        ]);
    }

    public function connexion() {
        $this->render('home/connexion');
    }

    public function login() {
        $this->render('home/login');
    }
}