<?php

    include_once('sessionManager.php');

    if(isset($_SESSION['email'])) {
        header("Location: index.php");
    }
?>  
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Login &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Login page to the DevSpace" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
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
                <h1>Dev Space</h1>
                <h2>You're going to login to <strong>DevSpace</strong></h2>
            </div>
            <div id="login-error-box-zone"></div>
            <div class="regform-main-section">
                <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $result = User::login($email, $password);
                        if($result) {
                            $_SESSION['email'] = $email;
                            $_SESSION['userInfo'] = serialize(User::getUserInfo($email));
                            header("Location: ".SessionManager::getPageRedirect());
                            die();
                        } else { //Stampa dell'errore
                            echo '<ul class="regform-errorbox">
                            <li>Wrong credentials, try again!</li>
                            </ul>
                            ';
                        }
                    }
                ?>
                <form action="login.php" id="login-main-form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lemail">Email</label>
                            <?php
                            if(isset($_POST['email'])){
                                echo '<input class="profile-input" type="email" value="'.$_POST['email'].'" id="lemail" name="email" placeholder="someone@example.com" required onchange="LoginPage_HideChangeLoginDataError()" />';
                            }else{
                                echo '<input class="profile-input" type="email" id="lemail" name="email" placeholder="someone@example.com" required onchange="LoginPage_HideChangeLoginDataError()" />';
                            }
                            ?>
                        </p>
                        <p>
                            <label for="lpassword">Password</label>
                            <input class="profile-input" type="password" id="lpassword" name="password" placeholder="Password" required onchange="LoginPage_HideChangeLoginDataError()" />
                        </p>
                        <p>
                            <input class="profile-input" name="submit" type="submit" value="Login" />
                        </p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-side-section">
                <p>Not yet registered?<a href='registrazione.php'>Register</a> to create a new account.</p>
                <p>Did you forget your password?<a href='forgotPassword.php'>Recover it.</a></p>
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