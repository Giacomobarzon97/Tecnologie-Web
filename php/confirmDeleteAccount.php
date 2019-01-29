<?php

    include_once('sessionManager.php');

    if(!isset($_POST['delete_account'])) {
        header("Location: index.php");
    }
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Elimina Account &#124; DevSpace</title>
		<meta charset="UTF-8">
        <meta name="description" content="Conferma eliminazione account" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
		<meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
        
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
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
                    <fieldset>
                        <p><input class='profile-input' name='conf_delete' type='submit' value='Si, sono sicuro' /></p>
                        <p><input class='profile-input' name='dismiss_conf_delete' type='submit' value='Annulla' /></p>
                    </fieldset>
                </form>
            </div>
            <ul id="regform-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About</a></li>
            </ul>
        </div>	
    </body>
</html>