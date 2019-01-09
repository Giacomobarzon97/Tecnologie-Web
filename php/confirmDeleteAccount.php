<?php

    include_once('sessionManager.php');

    if(!isset($_POST['delete_account'])) {
        header("Location: index.php");
    }
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>WebSite-Profile</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="progetto tec-web" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="language" content="italian it" />
        <meta name="author" content="" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        
    </head>
    
    <body>
        <div id="registration-form">
            <div class="regform-introduction">
                <h1><a href="index.html">Eliminazione dell'account</a></h1>
                <h2>Sei sicuro di voler eliminare il tuo account?</h2>
            </div>
            <div class="regform-main-section">
                <form action="profile.php" method="POST" >
                    <input class='profile-input' name='conf_delete' type='submit' value='Si, sono sicuro' />
                    <input class='profile-input' name='dismiss_conf_delete' type='submit' value='Annulla' />
                </form>
            </div>
            <ul id="regform-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About</a></li>
            </ul>
        </div>	
    </body>
</html>