<?php
    include_once ('sessionManager.php');
    include_once ("User.php");
?>  
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Your profile &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina profilo personale" />
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
        <?php
        include_once('navbar.php');
        SimpleNavbar::printSimpleNavbar();
        ?>
        <div id="registration-form">
        <?php 
            $nickname = unserialize($_SESSION['userInfo'])->nickname;
            if(User::isBanned($nickname)) {
                echo '<div id="login-error-box-zone"></div>
                <div class="regform-main-section">
                <ul class="regform-errorbox">
                                <li>Your account has been suspended, you can\'t leave comments and/or
                                like/dislike any article. In order to get back your features, an admin user
                                have to remove your suspension.</li>
                                </ul>
                            </div>';
            }
        ?>
            <div class="regform-introduction">
                <h1>Welcome back user!</h1>
                <?php 
                    if(isset($_SESSION['email'])) {
                        echo "<p>You are currently logged in as: ".$_SESSION['email']."</p>";
                    } else {
                        header("Location: errore.php?errorCode=paginaNonDisponibile");
                        die();
                    }
                    ?>
                
                <h2>Edit your information</h2>
            </div>
            <div id="profile-error-box-base-data"></div>
            <div class="regform-main-section">
                <?php
                    if(isset($_POST['submitChangeInfo'])) {
                        if(isset($_POST['nickname'])) {
                            $result = User::changeNickname($_SESSION['email'], $_POST['nickname']);
                            if($result) {
                                echo '<ul class="regform-successbox"><li>Nickname updated successfully!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo '<ul class="regform-errorbox"><li>The new nickname is not valid!</li></ul>';
                            }
                        }
                        
                        if(isset($_POST['name'])) {
                            $result = User::changeName($_SESSION['email'], $_POST['name']);
                            if($result) {
                                echo '<ul class="regform-successbox"><li>Name successfully updated!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo '<ul class="regform-errorbox"><li>The new name is invalid!</li></ul>';
                            }
                        }

                        if(isset($_POST['surname'])) {
                            $result = User::changeSurname($_SESSION['email'], $_POST['surname']);
                            if($result) {
                                echo '<ul class="regform-successbox"><li>Surname updated successfully!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo '<ul class="regform-errorbox"><li>The new surname is invalid!</li></ul>';
                            }
                        }
                        
                    }
                ?>
                <form action="profile.php" id="change_basic_data_form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lnickname">Nickname</label>
                            <input class="profile-input" type="text" id="lnickname" name="nickname" maxlength="100" required onchange="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->nickname;?>"/>
                        </p>
                        <p>
                            <label for="lname">Name</label>
                            <input class="profile-input" type="text" id="lname" name="name" pattern="^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$" title="Il tuo nome" maxlength="100" required onchange="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->name;?>"/>
                        </p>
                        <p>
                            <label for="lsurname">Surname</label>
                            <input class="profile-input" type="text" id="lsurname" name="surname" pattern="^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$" title="Il tuo cognome" maxlength="100" required onchange="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->surname;?>"/>
                        </p>
                        <p><input class="profile-input" name="submitChangeInfo" type="submit" value="Update information" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Change your password</h2>
            </div>
            <div id="profile-error-box-change-pw"></div>
            <div class="regform-main-section">
                <?php 
                    if(isset($_POST['submitChangePassword'])) {
                        $result = User::changePassword($_SESSION['email'], $_POST['old-password'], $_POST['new-password'], $_POST['conf-new-password']);
                        if($result->getIsError()){
                            echo '<ul class="regform-errorbox"><li>'.$result->getMessage().'</li></ul>';
                        }else{
                            echo '<ul class="regform-successbox"><li>'.$result->getMessage().'</li></ul>';
                        }
                        
                    }
                ?>
                <form action="profile.php" id="change_pw_form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lold-password">Current Password</label>
                            <input class="profile-input" type="password" id="lold-password" name="old-password" placeholder="Password attuale" maxlength="100" required onchange="ProfilePage_HideChangePWError()" />
                        </p>
                        <p>
                            <label for="lnew-password">New password</label>
                            <input class="profile-input" type="password" id="lnew-password" name="new-password" placeholder="Nuova password" maxlength="100" required onchange="ProfilePage_HideChangePWError()" />
                        </p>
                        <p>
                            <label for="lconf-new-password">Confirm new password</label>
                            <input class="profile-input" type="password" id="lconf-new-password" name="conf-new-password" placeholder="Conferma nuova password" maxlength="100" required onchange="ProfilePage_HideChangePWError()" />
                        </p>
                        <p><input class="profile-input" name="submitChangePassword" type="submit" value="Change Password" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Delete your account</h2>
            </div>
            <div class="regoform-main-section">
            <form action="confirmDeleteAccount.php" method="POST" >
                <p><input class="profile-input" name="delete_account" type="submit" value="Delete your account" /></p>
            </form>
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