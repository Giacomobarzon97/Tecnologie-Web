<?php

    include_once('sessionManager.php');

    if(isset($_SESSION['nickname'])) {
        header("Location: ".SessionManager::getPageRedirect());
    }
?> 
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Password Dimenticata &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Password dimenticata nella piattaforma DevSpace" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="theme-color" content="#F5F5F5" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
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
                    <fieldset>
                        <p>
                            <label for="lemail">Email</label>
                            <input class="profile-input" type="email" id="lemail" name="email" placeholder="Email@some.boh" required />
                        </p>
                        <p><input class="profile-input" name="submit" type="submit" value="Recupera" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-side-section">
                <p>Non sei ancora registrato?
                <p>Clicca <a href='registrazione.php'>qui</a> per creare un nuovo account.</p>
            </div>
            <ul id="regform-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About</a></li>
            </ul>
        </div>	
    </body>
</html>