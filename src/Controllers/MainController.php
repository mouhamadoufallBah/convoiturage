<?php 

namespace Convoiturage\Convoiturage\Controllers;

class MainController extends Controller
{
    public function index()
    {
        $this->render('main/acceuil');
    }
    public function search()
    {
        $this->render('main/search');
    }
    public function about()
    {
        $this->render('main/about');
    }
}