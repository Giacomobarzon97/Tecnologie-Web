<?php

include_once ("User.php");

function upload($name, $size, $type, $tmp_name) {
        $dirToSave = 'uploads/';
        $allow = array("jpg", "jpeg", "png");
        /*$name = $_FILES['upfile']['name'];
        $size = $_FILES['upfile']['size'];
        $type = $_FILES['upfile']['type'];
        $tmp_name = $_FILES['upfile']['tmp_name'];*/
    
        if (isset($name)) {
            if (!empty($name)) {
                $info = explode('.', strtolower( $_FILES['upfile']['name']) );
                if (in_array(end($info), $allow)) {
                    //Controllo se il file esiste
                    if(file_exists($dirToSave.$name)){
                        //Se sì separo nome ed estensione
                        $extension = "";
                        if(strpos($name, 'jpeg') !== false){
                            $extension = substr($name, -5);
                            $name = substr($name, 0, -5);
                        }else{
                            $extension = substr($name, -4);
                            $name = substr($name, 0, -4);
                        }
                        //E ci attacco una stringa random finchè non trovo un file inesistente
                        $name = $name.User::generateRandomString(rand(10, 100));
                        while(file_exists($dirToSave.$name.$extension)) {
                            $name = $name.User::generateRandomString(rand(10, 100));
                        }
                        $name = $name.$extension;
                    }
                    
                    if(move_uploaded_file($tmp_name, $dirToSave.$name)) {
                        //echo 'File caricato nella cartella /uploads';
                        
                        return $dirToSave.$name;
                    } else {
                        //echo "File non caricato! Errore GENERICO, AHIA!";
                        return NULL;
                    }
                } else {
                    //echo "Il file non è un'immagine, pertanto non può essere caricato.";
                    return NULL;
                }
            } else {
                //echo 'Scegli un file da caricare!';
                return NULL;
            }
        }
}//function upload

function resizeImage($image, $sizeWidth, $sizeHeight, $fileExtension) {
    $error[0] = 0;
    $resourceImage = false;
    switch($estensioneFile) {
        case 'jpeg':
            $resourceImage = imagecreatefromjpeg($image["tmp_name"]);
            break;
        case 'png':
            $resourceImage = imagecreatefrompng($image["tmp_name"]);
            break;
        case 'gif':
            $resourceImage = imagecreatefromgif($image["tmp_name"]);
            break;
        default:
            $error[0] = 1;
            break;
    }
    if ($resourceImage !== false) {
        $scaledImage = imagescale($resourceImage, $sizeWidth, $sizeHeight);
        if ($scaledImage !== false) {
            $ok = false;
            //delImage($immagine["tmp_name"]);
            switch ($estensioneFile) {
                case 'jpeg':
                    $ok = imagejpeg($scaledImage, $immagine["tmp_name"]);
                    break;
                case 'png':
                    $ok = imagepng($scaledImage, $immagine["tmp_name"]);
                    break;
                case 'gif':
                    $ok = imagegif($scaledImage, $immagine["tmp_name"]);
                    break;
            }
            if ($ok === false)
                $error[0] = 1;
        }
        else
            $error[0] =1;
    }
    else
        $error[0] = 1;
    return $error;
}


//Cancella un file
//Il nome è tutto il path cartella/nomefile
function deleteFile($name){
    unlink($name);
}

?>