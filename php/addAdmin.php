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
    <title>Administrators management &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Page to add administrators" />
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
        <button onclick="topFunction()" id="retTop" title="Torna su"></button>
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
        } else {
            echo '<div id="registration-form">
                <div class="regform-introduction">
                    <h2>Add a new administrator</h2>
                </div>
                <div id="add-admin-error-box-zone"></div>
                <div class="regform-main-section">';
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];

                $result = User::addAdmin($email);
                if ($result->getIsError()) {
                    echo '<ul class="regform-errorbox">';
                } else {
                    echo '<ul class="regform-successbox">';
                }
                echo $result->getMessage();
                echo "</ul>";
            }

            echo '<form action="addAdmin.php" id="add-admin-form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lemail">Email</label>
                            <input class="profile-input" type="email" id="lemail" name="email" placeholder="someone@example.com" required onchange="AddAdmin_HideAddAdminEmailError()" />
                        </p>
                        <p>
                            <input class="profile-input" name="submit" type="submit" value="Add as admin" />
                        </p>
                    </fieldset>
                </form>
            </div>
            <div>';
            User::printAllAdmin();
            echo '</div>';
            echo '</div>'; //chiusura div registration-form
        }//fine if is banned
        echo '<noscript>';
        SimpleNavbar::printSimpleNavbar(true);
        echo '</noscript>';
        echo '<noscript>';
        SimpleNavbar::printNoJSWarning();
        echo '</noscript>';
        ?>
    </body>
</html>