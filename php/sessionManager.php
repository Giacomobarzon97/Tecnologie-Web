<?php

    session_start();

    $pagesToIgnore = array("login.php", "errore.php", "registrazione.php", "forgotPassword.php", "recoverPassword.php",
        "logout.php", "confirmDeleteAccount.php", "manageUsers.php", "adminTools.php", "addAdmin.php");

    $shouldBeIgnored = false;

    //Controllo se la pagina va ignorata
    foreach($pagesToIgnore as $page){
        if (strpos($_SERVER['REQUEST_URI'], $page)) {
            $shouldBeIgnored = true;
        }
    }

    if($_SERVER['REQUEST_URI'] == "/"){
        $page_string = substr($_SERVER['PHP_SELF'], 1);
    }else{
        if(substr($_SERVER['REQUEST_URI'], 0, 1) == "/"){
            $page_string = substr($_SERVER['REQUEST_URI'], 1);
        }else{
            $page_string = $_SERVER['REQUEST_URI'];
        }
    }
    //Mi salvo la pagina attuale
    $_SESSION["breadcrumb"] = $page_string;

    //Se non va ignorata aggiorno l'ultima pagina visitata
    if(!$shouldBeIgnored){
        $_SESSION["lastVisitedPage"] = $page_string;
    }


    class SessionManager {

        //Metodo comodo per il redirect all'ultima pagina visitata
        static function getPageRedirect(){
            if(isset($_SESSION["lastVisitedPage"])){
                return $_SESSION["lastVisitedPage"];
            }else{
                return "index.php";
            }
        }

    }//End class

?>