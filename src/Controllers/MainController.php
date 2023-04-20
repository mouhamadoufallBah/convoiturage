<?php 

namespace Convoiturage\Convoiturage\Controllers;
use Convoiturage\Convoiturage\Models\ReservationModel;

class MainController extends Controller
{
    public function index()
    {
        $this->render('main/acceuil');
    }
    public function about()
    {
        $this->render('main/about');
    }
}