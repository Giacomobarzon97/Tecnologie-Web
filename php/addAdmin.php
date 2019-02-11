<?php
    include_once ('sessionManager.php');
    include_once ('User.php');
    
    if(!isset($_SESSION['email'])) {
        header("Location: errore.php?errorCode=paginaNonDisponibile");
    }

    if(!User::isAdmin($_SESSION['email'])){
        header("Location: errore.php?errorCode=nonAdmin");
    }

    if(User::isBanned($_SESSION['email'])){
        header("Location: errore.php?errorCode=bannanto");
    }
?>  
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Administrators management &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina aggiunta admin" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        
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
                die();
            }
        ?>
        <div id="registration-form">
            <div class="regform-introduction">
                <h2>Add a new administrator</h2>
            </div>
            <div id="add-admin-error-box-zone"></div>
            <div class="regform-main-section">
                <?php 

                    if(isset($_POST['submit'])){
                        $email = $_POST['email'];
                        
                        $result = User::addAdmin($email);
                        if($result->getIsError()){
                            echo '<ul class="regform-errorbox">';
                        }else{
                            echo '<ul class="regform-successbox">';
                        }
                        echo $result->getMessage();
                        echo "</ul>";
                    }
                ?>
                <form action="addAdmin.php" id="add-admin-form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lemail">Email</label>
                            <input class="profile-input" type="email" id="lemail" name="email" placeholder="Email@some.boh" required onchange="AddAdmin_HideAddAdminEmailError()" />
                        </p>
                        <p>
                            <input class="profile-input" name="submit" type="submit" value="Esegui" />
                        </p>
                    </fieldset>
                </form>
            </div>
            <div>
                    <?php User::printAllAdmin(); ?>
            </div>
        </div>
        <?php
            echo '<noscript>';
            SimpleNavbar::printSimpleNavbar(true);
            echo '</noscript>';
        ?>
    </body>
</html>