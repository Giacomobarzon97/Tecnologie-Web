<?php

    include_once('sessionManager.php');

    if(isset($_SESSION['nickname'])) {
        header("Location: ".SessionManager::getPageRedirect());
    }
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forgot password &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Forgotten password on the DevSpace website" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="theme-color" content="#F5F5F5" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="./style/style.css" />
        <link rel="stylesheet" type="text/css" href="./style/print.css" media="print"/>
        <script src="./script/scripts.js"></script>
        
    </head>
    
    <body>
        <?php
        include_once('navbar.php');
        SimpleNavbar::printSimpleNavbar();
        ?>
        <div id="registration-form">
            <div class="regform-introduction">
                <h2>Get an email to recover your password</h2>
            </div>
            <div class="regform-main-section">
            <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){
                        $email = $_POST['email'];
                        $result = User::passwordRecover($email);
                        if($result) {
                            echo '<ul class="regform-successbox">';
                            echo '<li>Password recovery e-mail sent!</li>';
                            echo '</ul>';
                        } else {
                            echo '<ul class="regform-errorbox">';
                            echo '<li>The e-mail you entered is not registered!</li>';
                            echo '</ul>';
                        }
                    } 
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <fieldset>
                        <p>
                            <label for="lemail">Email</label>
                            <input class="profile-input" type="email" id="lemail" name="email" placeholder="Email@some.boh" required />
                        </p>
                        <p><input class="profile-input" name="submit" type="submit" value="Recover password" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-side-section">
                <p>Not yet registered?
                <p>Click <a href='registrazione.php'>here</a> to create a new account.</p>
            </div>
            <?php
            echo '<noscript>';
            SimpleNavbar::printSimpleNavbar(true);
            echo '</noscript>';
            ?>
        </div>
        <?php
        echo '<noscript>';
        SimpleNavbar::printNoJSWarning();
        echo '</noscript>';
        ?>
    </body>
</html>