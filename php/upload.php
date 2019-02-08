<?php

include_once ("User.php");
include_once ("ResultManager.php");

function upload($name, $size, $type, $tmp_name) {
        $dirToSave = 'uploads/';
        $allow = array("jpg", "jpeg", "png");

        //Sopra 3MB non accetto
        if($size > 3000000){
            return new ResultManager("<li>The uploaded file is too big and exceed 3MB!</li>", true);
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
                        return new ResultManager("<li>An error occurred while resizing the image!</li>", true);
                    }
                    if(move_uploaded_file($tmp_name, $dirToSave.$name)) {
                        $result =  new ResultManager("<li>Upload completed successfully</li>");
                        $result->data_message = $dirToSave.$name;
                        return $result;
                    } else {
                        return new ResultManager("<li>An error occurred while moving the uploaded file!</li>", true);
                    }
                } else {
                    return new ResultManager("<li>You cannot upload that file, only jpg, jpeg or png!</li>", true);
                }
            } else {
                return new ResultManager("<li>An error occurred: the filename looks not valid!</li>", true);
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