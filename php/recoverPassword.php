<?php

    include_once('sessionManager.php');

    if(isset($_SESSION['nickname'])) {
        header("Location: ".SessionManager::getPageRedirect());
    }
    if(!isset($_GET['token']) && !isset($_POST['change_pw_token'])){
        header("Location: ".SessionManager::getPageRedirect());
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
                <h1><a href="index.html">Nome del sito</a></h1>
                <h2>Reimposta la password</h2>
            </div>
            <div class="regform-main-section">
            <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){
                        $result = User::passwordRecoveryChange($_POST['change_pw_token'], $_POST['password']);
                        if($result) {
                            echo '<span>Password cambiata con successo!</span><br/>';
                        } else {
                            echo '<span>C\'è stato un errore nel recuperare la password, controlla che il token sia corretto o che non sia scaduto :(</span><br/>';
                        }
                    } 
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="lpassword">Password</label>
                <input class="profile-input" type="password" id="lpassword" name="password" placeholder="Password" />

                <label for="lpassword-confirm">Conferma la Password</label>
                <input class="profile-input" type="password" id="lpassword-confirm" name="password" placeholder="Conferma la Password" />
                
                <?php
                if(isset($_GET['token'])){ //Alla prima apertura stampo il token dal get
                    echo '<input type="hidden" name="change_pw_token" value="'.$_GET['token'].'" />';
                }else{ //Nel caso di riapertura della pagina dopo la richiesta lo prendo dal post
                    echo '<input type="hidden" name="change_pw_token" value="'.$_POST['change_pw_token'].'" />';
                }
                ?>
                <input class="profile-input" name="submit" type="submit" value="Reimposta" />
                </form>
            </div>
            <div class="regform-side-section">
                <p>Non sei ancora registrato?
                <p>Clicca <a href='registrazione.php'>qui</a> per creare un nuovo account.</p>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About</a></li>
            </ul>
        </div>	
    </body>
</html>