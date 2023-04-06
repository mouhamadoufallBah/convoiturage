<?php

use Convoiturage\Convoiturage\Core\Router;
require_once('../config/constante.php');

require_once(ROOT.'/vendor/autoload.php');



$app = new Router();

$app->start();