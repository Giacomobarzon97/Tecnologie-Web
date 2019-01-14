<?php

include_once ("User.php");

function upload($name, $size, $type, $tmp_name) {
        $dirToSave = 'uploads/';
        $allow = array("jpg", "jpeg", "png");

        //Sopra 3MB non accetto
        if($size > 3000000){
            return NULL;
        }

        //Prendo l'estensione del file
        $extension = "";
        if(strpos($name, 'jpeg') !== false){
            $extension = substr($name, -5);
        }else{
            $extension = substr($name, -4);
        }
    
        if (isset($name)) {
            if (!empty($name)) {
                $info = explode('.', strtolower( $_FILES['upfile']['name']) );
                if (in_array(end($info), $allow)) {
                    //Controllo se il file esiste
                    if(file_exists($dirToSave.$name)){
                        //Se sì separo nome ed estensione
                        if(strpos($name, 'jpeg') !== false){
                            $name = substr($name, 0, -5);
                        }else{
                            $name = substr($name, 0, -4);
                        }
                        //E ci attacco una stringa random finchè non trovo un file inesistente
                        $name = $name.User::generateRandomString(rand(10, 100));
                        while(file_exists($dirToSave.$name.$extension)) {
                            $name = $name.User::generateRandomString(rand(10, 100));
                        }
                        $name = $name.$extension;
                    }
                    if(!resizeImage($tmp_name, 300, 150, $extension)){
                        return NULL;
                    }
                    if(move_uploaded_file($tmp_name, $dirToSave.$name)) {
                        return $dirToSave.$name;
                    } else {
                        return NULL;
                    }
                } else {
                    return NULL;
                }
            } else {
                return NULL;
            }
        }
}//function upload

function resizeImage($image, $sizeWidth, $sizeHeight, $estensioneFile) {
    $resourceImage = false;
    switch($estensioneFile) {
        case '.jpg':
        case '.jpeg':
            $resourceImage = imagecreatefromjpeg($image);
            break;
        case '.png':
            $resourceImage = imagecreatefrompng($image);
            break;
        default:
            return false;
    }
    if ($resourceImage !== false) {
        $scaledImage = imagescale($resourceImage, $sizeWidth, $sizeHeight);
        if ($scaledImage !== false) {
            $ok = false;
            switch ($estensioneFile) {
                case '.jpg':
                case '.jpeg':
                    $ok = imagejpeg($scaledImage, $image);
                    break;
                case '.png':
                    $ok = imagepng($scaledImage, $image);
                    break;
            }
            if ($ok === false)
                return false;
        }
        else
            return false;
    }
    else
        return false;
    return true;
}


//Cancella un file
//Il nome è tutto il path cartella/nomefile
function deleteFile($name){
    if(file_exists($name)){
        unlink($name);
    }
}

?>