<?php

    include_once('sessionManager.php');

    if(isset($_SESSION['nickname'])) {
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
                <h2>Hai dimenticato la password? Recuperala!</h2>
            </div>
            <div class="regform-main-section">
            <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){
                        $email = $_POST['email'];
                        $result = User::passwordRecover($email);
                        if($result) {
                            echo '<span>Email di recupero password inviata!</span><br/>';
                        } else {
                            echo '<span>L\'email che hai inserito non è registrata!</span><br/>';
                        }
                    } 
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <label for="lemail">Email</label>
                    <input class="profile-input" type="text" id="lemail" name="email" placeholder="Email@some.boh" />
                
                    <input class="profile-input" name="submit" type="submit" value="Recupera" />
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