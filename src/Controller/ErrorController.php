<?php

namespace App\src\Controller;

class ErrorController extends AbstractController
{
    public function index()
    {
        $this->render('error/404');
    }

    public function error404()
    {
        $this->index();
    }
}