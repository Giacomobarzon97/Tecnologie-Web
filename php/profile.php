<?php
    session_start();
    include_once ("User.php");

    if(isset($_POST['dismiss_conf_delete'])) {
        header("Location: profile.php");
    }

    if(isset($_POST['conf_delete'])) {
        User::deleteAccount($_SESSION['email']);
        session_destroy();
        header("Location: index.php");
    }
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>WebSite-Profile</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="progetto tec-web" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="language" content="italian it" />
        <meta name="author" content="" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>

    </head>

    <body>
        <div id="registration-form">

            <div class="regform-introduction">
                <h1>Bentornato utente!</h1>
                <?php 
                    if(isset($_SESSION['email'])) {
                        echo "<p>Sei attualmente loggato come: ".$_SESSION['email']."</p>";
                    } else {
                        header("Location: errore.php?errorCode=paginaNonDisponibile");
                        die();
                    }
                    ?>
                
                <h2>Modifica le tue informazioni</h2>
            </div>
            <div id="profile-error-box-base-data"></div>
            <div class="regform-main-section">
                <?php
                    if(isset($_POST['submitChangeInfo'])) {
                        if(isset($_POST['nickname'])) {
                            $result = User::changeNickname($_SESSION['email'], $_POST['nickname']);
                            if($result) {
                                echo "<span>Nickname aggiornato con successo!</span><br/>";
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo "<span>Nuovo nickname non valido!</span><br/>";
                            }
                        }
                        
                        if(isset($_POST['name'])) {
                            $result = User::changeName($_SESSION['email'], $_POST['name']);
                            if($result) {
                                echo "<span>Nome aggiornato con successo!</span><br/>";
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo "<span>Nuovo nome non valido!</span><br/>";
                            }
                        }

                        if(isset($_POST['surname'])) {
                            $result = User::changeSurname($_SESSION['email'], $_POST['surname']);
                            if($result) {
                                echo "<span>Cognome aggiornato con successo!</span><br/>";
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo "<span>Nuovo cognome non valido!</span><br/>";
                            }
                        }
                        
                    }
                ?>
                <form action="profile.php" id="change_basic_data_form" method="POST">
                    <label for="lnickname">Nickname</label>
                    <input class="profile-input" type="text" id="lnickname" name="nickname" maxlength="100" required onfocus="ProfilePage_HideChangeBasicDataPWError()"
                    value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->nickname;?>"/>
                    <label for="lname">Nome</label>
                    <input class="profile-input" type="text" id="lname" name="name" pattern="[A-Za-z]+" title="Il tuo nome" maxlength="100" required onfocus="ProfilePage_HideChangeBasicDataPWError()"
                    value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->name;?>"/>
                    <label for="lsurname">Cognome</label>
                    <input class="profile-input" type="text" id="lsurname" name="surname" pattern="[A-Za-z]+" title="Il tuo cognome" maxlength="100" required onfocus="ProfilePage_HideChangeBasicDataPWError()"
                    value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->surname;?>"/>
                    <input class="profile-input" name="submitChangeInfo" type="submit" value="Submit" />
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Modifica la tua password</h2>
            </div>
            <div id="profile-error-box-change-pw"></div>
            <div class="regform-main-section">
            <?php 
                if(isset($_POST['submitChangePassword'])) {
                    $message = User::changePassword($_SESSION['email'], $_POST['old-password'], $_POST['new-password'], $_POST['conf-new-password']);
                    echo "<span>$message</span>";
                }
            ?>
                <form action="profile.php" id="change_pw_form" method="POST">
                    <label for="lold-password">Password attuale</label>
                    <input class="profile-input" type="password" id="lold-password" name="old-password" placeholder="Password attuale" maxlength="100" required onfocus="ProfilePage_HideChangePWError()" />
                    <label for="lnew-password">Nuova password</label>
                    <input class="profile-input" type="password" id="lnew-password" name="new-password" placeholder="Nuova password" maxlength="100" required onfocus="ProfilePage_HideChangePWError()" />
                    <label for="lconf-new-password">Conferma Nuova password</label>
                    <input class="profile-input" type="password" id="lconf-new-password" name="conf-new-password" placeholder="Conferma nuova password" maxlength="100" required onfocus="ProfilePage_HideChangePWError()" />

                    <input class="profile-input" name="submitChangePassword" type="submit" value="Submit" />
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Elimina il tuo account</h2>
            </div>
            <div class="regoform-main-section">
            <form action="confirmDeleteAccount.php" method="POST" >
                <input class="profile-input" name="delete_account" type="submit" value="Elimina il tuo account" />
            </form>
            </div>  
            <ul id="regform-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>	
    </body>
</html>