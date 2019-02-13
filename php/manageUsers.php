<?php
    include_once ('sessionManager.php');
    include_once ('User.php');
    
    if(!isset($_SESSION['email'])) {
        header("Location: errore.php?errorCode=paginaNonDisponibile");
    }

    if(!User::isAdmin($_SESSION['email'])){
        header("Location: errore.php?errorCode=nonAdmin");
    }
?>  
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Account suspension &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina di sospensione account utente" />
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
        <button onclick="topFunction()" id="retTop" title="Back to the top"></button>
        <?php
        include_once('navbar.php');
        SimpleNavbar::printSimpleNavbar();

        $nickname = unserialize($_SESSION['userInfo'])->nickname;
        if(User::isBanned($nickname)) {
            echo '<div id="registration-form">
            <div id="login-error-box-zone"></div>
            <div class="regform-main-section">
            <ul class="regform-errorbox">
            <li>Your account has been suspended, you can\'t use admin tools anymore. In order to get back your admin role
            another user have to remove your suspension.</li>
            </ul>
            </div>
            </div>';

        }else{

            echo '<div id="registration-form">
                <div class="regform-introduction">
                    <h2>Suspend a user account</h2>
                </div>
                <div id="ban-user-error-box-zone"></div>
                <div class="regform-main-section">';


                        if(isset($_POST['submit'])){
                            $nickname = $_POST['nickname'];

                            $result = User::userSuspend($nickname);
                            if(!$result->getIsError()) {
                                echo '<ul class="regform-successbox"><li>'.$result->getMessage().'</li></ul>';
                            } else { //Stampa dell'errore
                                echo '<ul class="regform-errorbox">
                                <li>'.$result->getMessage().'</li>
                                </ul>
                                ';
                            }
                        }

                        if(isset($_POST['submitNicknameDel'])) {
                            $nick = $_POST['nicknameDel'];
                            $result = User::removeSuspension($nick);
                            if($result) {
                                echo '<ul class="regform-successbox"><li>Removal of suspension successfully completed!</li></ul>';
                            } else { //Stampa dell'errore
                                echo '<ul class="regform-errorbox">
                                <li>Suspension already removed or non-existent user!</li>
                                </ul>
                                ';
                            }
                        }

                    echo '<form action="manageUsers.php" id="ban-user-form" method="POST">
                        <fieldset>
                            <p>
                                <label for="lnickname">Nickname</label>
                                <input class="profile-input" type="text" id="lnickname" name="nickname" placeholder="Nickname" required onchange="BanUser_HideBanUserError()" />
                            </p>
                            <p>
                                <input class="profile-input" name="submit" type="submit" value="Suspend" />
                            </p>
                        </fieldset>
                    </form>
                </div>
                <div>';
                    User::printAllBannedUsers();
                echo '</div>';
                echo '</div>';
            }
            echo '<noscript>';
            SimpleNavbar::printSimpleNavbar(true);
            echo '</noscript>';
            ?>

        <?php
        echo '<noscript>';
        SimpleNavbar::printNoJSWarning();
        echo '</noscript>';
        ?>
    </body>
</html>