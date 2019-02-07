<?php
    
    include_once('sessionManager.php');

    if (isset($_SESSION['email'])) {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Registrazione &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina di registrazione a DevSpace" />
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
        <button onclick="topFunction()" id="retTop" title="Torna su"></button>
        <?php include_once ('navbar.php'); ?>
        <div id="registration-form">
            <div class="regform-introduction">
                <h2>Effettua la registrazione a <strong>DevSpace</strong></h2>
            </div>
            <div id="register-error-box-zone"></div>
            <div class="regform-main-section">
                <?php 
                    include_once ('User.php');

                    if(isset($_POST['submit'])){ //check if form was submitted
                        $email = $_POST['email'];
                        $nickname = $_POST['nickname'];
                        $name = $_POST['name'];
                        $surname = $_POST['surname'];
                        $password = $_POST['password'];
                        $result = User::registration($email, $nickname, $password, $name, $surname);
                        if($result->getIsError()){
                            echo '<ul class="regform-errorbox">';
                        }else{
                            echo '<ul class="regform-successbox">';
                        }
                        echo $result->getMessage();
                        echo "</ul>";
                    }
                    if(!isset($_POST['submit']) || $result->getIsError()){
                        echo '<form action="registrazione.php" id="register-main-form" method="POST">
                            <fieldset>
                                <p>
                                <label for="lemail">Email</label>';
                                    if(isset($_POST['submit'])){
                                        echo '<input class="profile-input" type="email" id="lemail" name="email" placeholder="Email@some.boh" maxlength="100" required value="'.$email.'"/>';
                                    }else{
                                        echo '<input class="profile-input" type="email" id="lemail" name="email" placeholder="Email@some.boh" maxlength="100" required />';
                                    }
                                echo '</p>
                                <p>
                                    <label for="lnickname">Nickname</label>';
                                    if(isset($_POST['submit'])){
                                        echo '<input class="profile-input" type="text" id="lnickname" name="nickname" placeholder="Nickname" maxlength="100" 
                                        required pattern=".{1,}" title="Il nickname deve essere almeno di un carattere" value="'.$nickname.'"/>';
                                    }else{
                                        echo '<input class="profile-input" type="text" id="lnickname" name="nickname" placeholder="Nickname" maxlength="100" 
                                        required pattern=".{1,}" title="Il nickname deve essere almeno di un carattere" />';
                                    }
                                echo '</p>
                                <p>
                                    <label for="lname">Nome</label>';
                                    if(isset($_POST['submit'])){
                                        echo '<input class="profile-input" type="text" id="lname" name="name" placeholder="Nome" pattern="[A-Za-z]+" title="Il tuo nome" maxlength="100" 
                                        required value="'.$name.'"/>';
                                    }else{
                                        echo '<input class="profile-input" type="text" id="lname" name="name" placeholder="Nome" pattern="[A-Za-z]+" title="Il tuo nome" maxlength="100" required />';
                                    }
                                echo '</p>
                                <p>
                                    <label for="lsurname">Cognome</label>';
                                    if(isset($_POST['submit'])){
                                        echo '<input class="profile-input" type="text" id="lsurname" name="surname" placeholder="Cognome" pattern="[A-Za-z]+" title="Il tuo cognome" maxlength="100" 
                                        required value="'.$surname.'"/>';
                                    }else{
                                        echo '<input class="profile-input" type="text" id="lsurname" name="surname" placeholder="Cognome" pattern="[A-Za-z]+" title="Il tuo cognome" maxlength="100" required />';
                                    }
                                echo '</p>
                                <p>
                                    <label for="lpassword">Password</label>
                                    <input class="profile-input" type="password" id="lpassword" name="password" placeholder="Password" maxlength="100" 
                                    required pattern=".{3,100}" title="La password deve avere tra 3 e 100 caratteri"/>
                                </p>
                                <p><input class="profile-input" name="submit" type="submit" value="Submit" /></p>
                            </fieldset>
                        </form>';
                    }
                ?>
            </div>
            <div class="regform-side-section">
                <p>Sei già registrato?
                <p>Clicca <a href='login.php'>qui</a> per effettuare il login.</p>
            </div>
        </div>	
    </body>
</html>