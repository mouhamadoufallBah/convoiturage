<?php

namespace Convoiturage\Convoiturage\Core;

use Convoiturage\Convoiturage\Models\ImageModel;

class Image
{
    public static function addImage($input)
    {
        if ($_POST) {
            if (isset($input) && !empty($input['name'])) {
                
                $images = [];

                $uploadsDir = 'assets/upload/users/';
                $images = array();

                foreach ($input['name'] as $key => $name) {
                    $tmp_name = $input['tmp_name'][$key];
                    $size = $input['size'];


                    //definition taille
                    $w = 150;
                    $h = 150;

                    //creation image
                    $newImage = imagecreatetruecolor($w, $h);

                    //redimensionner

                    $source_img = imagecreatefromjpeg($tmp_name);

                    $source_w = imagesx($source_img);
                    $source_h = imagesy($source_img);


                    imagecopyresampled($newImage, $source_img, 0, 0, 0, 0, $w, $h, $source_w, $source_h);


                    //enregistrer image redimensionner

                    $filename = uniqid("REF", true) . '.' . $name;
                    $imagePath = $uploadsDir . basename($filename);
                    imagejpeg($newImage, ($imagePath), 80);
                    $images[] = $imagePath;
                }


                foreach ($images as $i) {
                    $imageModel = new ImageModel();

                    $imageModel->setChemin($i);
                    $imageModel->setId_user($_SESSION['user']['id']);
                    $imageModel->create();
                }

                imagedestroy($source_img);
                imagedestroy($newImage);

            } else {
                $_SESSION['message'] = "erreur de chargement de l'image";
                header('Location: /security/profile');
            }
        }
    }



    public function removeImage()
    {
    }
}
