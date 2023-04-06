<?php 
namespace Convoiturage\Convoiturage\Controllers;

class Controller
{
    public function render(string $fichier, array $donnee = [], string $template = 'default')
    {
        //extraire les donnée
        extract($donnee);

        //demarer le buffer de sortie qui va conserver en memoire toute sorti
        ob_start();

        //on cree le chemin ver le vue
        require_once(SRC.'/views/'.$fichier.'.php');
        
        //transfer le buffer dans le $contenu
        $contenue = ob_get_clean();

        //appeller notre template de page
        require_once(SRC.'/views/'.$template.'.php');


    }
}