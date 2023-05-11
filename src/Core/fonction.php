<?php 
function url($path) {
    $baseUrl = 'http://convoiturage.test/'; // Remplacez par l'URL de votre application
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}

?>
