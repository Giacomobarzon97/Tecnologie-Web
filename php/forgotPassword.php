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
        <meta name="description" content="Password dimenticata nella piattaforma DevSpace" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="theme-color" content="#F5F5F5" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        
    </head>
    
    <body>
        <div id="registration-form">
            <div class="regform-introduction">
                <h1>DevSpace</h1>
                <h2>Did you forget your password? Retrieve it!</h2>
            </div>
            <div class="regform-main-section">
            <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){
                        $email = $_POST['email'];
                        $result = User::passwordRecover($email);
                        if($result) {
                            echo '<span>Password recovery e-mail sent!</span><br/>';
                        } else {
                            echo '<span>The e-mail you entered is not registered!</span><br/>';
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
            <ul id="regform-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About</a></li>
            </ul>
        </div>
        <?php
        echo '<noscript>';
        SimpleNavbar::printNoJSWarning();
        echo '</noscript>';
        ?>
    </body>
</html>