<?php

namespace App\Controller;

class ErrorController extends AbstractController
{
    public function index()
    {
        $this->render('error');
    }

    public function error404()
    {
        $this->index();
    }
}