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

//Cancella un file
//Il nome è tutto il path cartella/nomefile
function deleteFile($name){
    unlink($name);
}

?>