<?php
    include_once ('sessionManager.php');
    include_once ("User.php");
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Il tuo profilo &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina profilo personale" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
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
        <?php include_once ('navbar.php'); ?>
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
                                echo '<ul class="regform-successbox"><li>Nickname aggiornato con successo!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo '<ul class="regform-errorbox"><li>Nuovo nickname non valido!</li></ul>';
                            }
                        }
                        
                        if(isset($_POST['name'])) {
                            $result = User::changeName($_SESSION['email'], $_POST['name']);
                            if($result) {
                                echo '<ul class="regform-successbox"><li>Nome aggiornato con successo!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo '<ul class="regform-errorbox"><li>Nuovo nome non valido!</li></ul>';
                            }
                        }

                        if(isset($_POST['surname'])) {
                            $result = User::changeSurname($_SESSION['email'], $_POST['surname']);
                            if($result) {
                                echo '<ul class="regform-successbox"><li>Cognome aggiornato con successo!</li></ul>';
                                $_SESSION['userInfo'] = serialize(User::getUserInfo($_SESSION['email']));
                            } else {
                                echo '<ul class="regform-errorbox"><li>Nuovo cognome non valido!</li></ul>';
                            }
                        }
                        
                    }
                ?>
                <form action="profile.php" id="change_basic_data_form" method="POST">
                    <fieldset>
                        <p>
                            <label for="lnickname">Nickname</label>
                            <input class="profile-input" type="text" id="lnickname" name="nickname" maxlength="100" required onfocus="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->nickname;?>"/>
                        </p>
                        <p>
                            <label for="lname">Nome</label>
                            <input class="profile-input" type="text" id="lname" name="name" pattern="[A-Za-z]+" title="Il tuo nome" maxlength="100" required onfocus="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->name;?>"/>
                        </p>
                        <p>
                            <label for="lsurname">Cognome</label>
                            <input class="profile-input" type="text" id="lsurname" name="surname" pattern="[A-Za-z]+" title="Il tuo cognome" maxlength="100" required onfocus="ProfilePage_HideChangeBasicDataPWError()"
                            value="<?php if(isset($_SESSION['userInfo'])) echo unserialize($_SESSION['userInfo'])->surname;?>"/>
                        </p>
                        <p><input class="profile-input" name="submitChangeInfo" type="submit" value="Aggiorna informazioni" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Modifica la tua password</h2>
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
                            <label for="lold-password">Password attuale</label>
                            <input class="profile-input" type="password" id="lold-password" name="old-password" placeholder="Password attuale" maxlength="100" required onfocus="ProfilePage_HideChangePWError()" />
                        </p>
                        <p>
                            <label for="lnew-password">Nuova password</label>
                            <input class="profile-input" type="password" id="lnew-password" name="new-password" placeholder="Nuova password" maxlength="100" required onfocus="ProfilePage_HideChangePWError()" />
                        </p>
                        <p>
                            <label for="lconf-new-password">Conferma Nuova password</label>
                            <input class="profile-input" type="password" id="lconf-new-password" name="conf-new-password" placeholder="Conferma nuova password" maxlength="100" required onfocus="ProfilePage_HideChangePWError()" />
                        </p>
                        <p><input class="profile-input" name="submitChangePassword" type="submit" value="Cambia password" /></p>
                    </fieldset>
                </form>
            </div>
            <div class="regform-introduction">
                <h2>Elimina il tuo account</h2>
            </div>
            <div class="regoform-main-section">
            <form action="confirmDeleteAccount.php" method="POST" >
                <p><input class="profile-input" name="delete_account" type="submit" value="Elimina il tuo account" /></p>  
            </form>
            </div>  
        </div>	
    </body>
</html>