<?php
    include_once ('sessionManager.php');
    include_once ('User.php');
    if(!User::isAdmin($_SESSION['email'])){
        header("Location: index.php");
    }
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
    <title>Sospensione account &#124; DevSpace</title>
		<meta charset="UTF-8">
        <meta name="description" content="Pagina di sospensione account utente" />
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
    <?php include_once ('navbar.php'); ?>
        <div id="registration-form">
            <div class="regform-introduction">
                
                <h2>Sospendi l'account di un utente</h2>
            </div>
            <div id="login-error-box-zone"></div>
            <div class="regform-main-section">
                <?php 

                    if(isset($_POST['submit'])){
                        $nickname = $_POST['nickname'];
                        
                        $result = User::userSuspend($nickname);
                        if($result) {
                            echo "<span>Operazione avvenuta con successo</span>";
                        } else { //Stampa dell'errore
                            echo '<ul class="regform-errorbox">
                            <li>Utente già sospeso oppure inesistente!</li>
                            </ul>
                            ';
                        }
                    }

                    if(isset($_POST['submitNicknameDel'])) {
                        $nick = $_POST['nicknameDel'];
                        $result = User::removeSuspension($nick);
                        if($result) {
                            echo "<span>Operazione avvenuta con successo</span>";
                        } else { //Stampa dell'errore
                            echo '<ul class="regform-errorbox">
                            <li>Sospensone già rimossa o utente inesistente!</li>
                            </ul>
                            ';
                        }
                    }
                ?>
                <form action="manageUsers.php" id="login-main-form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lnickname">Nickname</label>
                            <input class="profile-input" type="text" id="lnickname" name="nickname" placeholder="Nickname" required onfocus="LoginPage_HideChangeLoginDataError()" />
                        </p>
                        <p>
                            <input class="profile-input" name="submit" type="submit" value="Esegui" />
                        </p>
                    </fieldset>
                </form>
            </div>
            <div>
                    <h3>Utenti sospesi</h3>
                    <?php User::printAllBannedUsers(); ?>
            </div>
        </div>	
    </body>
</html>