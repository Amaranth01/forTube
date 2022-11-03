<?php

namespace App\Controller;


class HomeController extends AbstractController
{
    public function index() {
        $this->render('home/index');
    }

    public function connexion() {
        $this->render('home/connexion');
    }

    public function login() {
        $this->render('home/login');
    }
}