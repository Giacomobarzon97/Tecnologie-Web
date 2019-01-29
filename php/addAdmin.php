<?php
    include_once('sessionManager.php');
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
    <title>Aggiunta amministratore &#124; DevSpace</title>
		<meta charset="UTF-8">
        <meta name="description" content="Pagina di login" />
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
                <ul id="regform-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
                
                <h2>Aggiungi un nuovo amministratore</h2>
            </div>
            <div id="login-error-box-zone"></div>
            <div class="regform-main-section">
                <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){
                        $email = $_POST['email'];
                        
                        $result = User::addAdmin($email);
                        if($result) {
                            echo "<div>Operazione avvenuta con successo</div>";
                        } else { //Stampa dell'errore
                            echo '<ul class="regform-errorbox">
                            <li>Utente già amministratore!</li>
                            </ul>
                            ';
                        }
                    }
                ?>
                <form action="addAdmin.php" id="login-main-form" method="POST">
                    <fieldset>
                        <p>
                            <input class="profile-input" type="email" id="lemail" name="email" placeholder="Email@some.boh" required onfocus="LoginPage_HideChangeLoginDataError()" />
                        </p>
                        <p>
                            <input class="profile-input" name="submit" type="submit" value="Esegui" />
                        </p>
                    </fieldset>
                </form>
            </div>
        </div>	
    </body>
</html>