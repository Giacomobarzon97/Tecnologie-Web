<?php

    include_once('sessionManager.php');

    if(!isset($_SESSION['email'])) {
        header("Location: errore.php?errorCode=paginaNonDisponibile");
    }

?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Recupera Password &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Password recovery page" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="theme-color" content="#F5F5F5" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
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
                <h2>Recover your password</h2>
            </div>
            <div class="regform-main-section">
            <?php
                include_once ('User.php');
                include_once ('validateData.php');

                $errorOccurred = false;
                $success = false;
                if(isset($_POST['submit'])){
                    if(!ValidateData::validatePassword($_POST['password']) || !ValidateData::validatePassword($_POST['password'])){
                        echo '<ul class="regform-errorbox">';
                        echo '<li>The password content is not valid (probably is empty or too short, must be at least 3 characters)!</li>';
                        echo '</ul>';
                    }else {
                        if ($_POST['password'] != $_POST['password-confirm']) {
                            echo '<ul class="regform-errorbox">';
                            echo '<li>The two passwords do not match!</li>';
                            echo '</ul>';
                        } else {
                            $result = User::passwordRecoveryChange($_POST['change_pw_token'], $_POST['password']);
                            if ($result) {
                                echo '<ul class="regform-successbox">';
                                echo '<li>Password changed successfully!</li>';
                                echo '</ul>';
                                echo '<ul id="regform-links">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="login.php">Login</a></li>
                            </ul>';
                                $success = true;
                            } else {
                                echo '<ul class="regform-errorbox">';
                                echo '<li>An error occurred in recovering the password, check that the token is correct or has not expired :(</li>';
                                echo '</ul>';
                                $errorOccurred = true;
                            }
                        }
                    }
                }
                if(!$success) {
                    //Controllo se il token esiste, altrimenti non stampo il form ma un messaggio di errore
                    if (
                        (User::checkIfTokenExist($_GET['token']))
                        ||
                        (User::checkIfTokenExist($_POST['change_pw_token']))
                        || $errorOccurred
                    ) { //Il token esiste
                        echo '<div id="forgot-pw-error-box-change-password"></div>
                    <form action="' . $_SERVER['PHP_SELF'] . '" method="POST" id="change-password-forgot-token">
                        <fielset>
                        <p><label for="lpassword">Password</label>
                        <input class="profile-input" type="password" id="lpassword" name="password" 
                        placeholder="Password" required onchange="RecoverPassword_HideChangePwError()" /></p>

                        <p><label for="lpassword-confirm">Confirm Password</label>
                        <input class="profile-input" type="password" id="lpassword-confirm" name="password-confirm" 
                        placeholder="Conferma la Password" required onchange="RecoverPassword_HideChangePwError()" /></p>
                        ';
                        if (isset($_GET['token'])) { //Alla prima apertura stampo il token dal get
                            echo '<input type="hidden" name="change_pw_token" value="' . $_GET['token'] . '" />';
                        } else { //Nel caso di riapertura della pagina dopo la richiesta lo prendo dal post
                            echo '<input type="hidden" name="change_pw_token" value="' . $_POST['change_pw_token'] . '" />';
                        }

                        echo '<p><input class="profile-input" name="submit" type="submit" value="Reset" /></p>
                        </fielset></form>';
                    } else { //Il token non esiste
                        echo 'Unfortunately the token provided for the password change is not valid... Check or request a new one...';
                    }
                }
            ?>
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