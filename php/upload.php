<?php

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
                    if(move_uploaded_file($tmp_name, $dirToSave.$name)) {
                        echo 'File caricato nella cartella /uploads';
                    } else {
                        echo "File non caricato! Errore GENERICO, AHIA!";
                    }
                } else {
                    echo "Il file non è un'immagine, pertanto non può essere caricato.";
                }
            } else {
                echo 'Scegli un file da caricare!';
            }
        }
}

?>