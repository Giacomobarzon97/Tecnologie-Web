<?php
    session_start();
    include_once ('pagesManager.php');
    if(isset($_SESSION['nickname'])) {
        header("Location: profile.php");
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
        <?php
            include_once ('navbar.php');
        ?>
    
        <div id="header">
			<h1>NOME SITO</h1>
		</div>
            <div id="profile-info">
                <div id="profile-content">
                    <h1>Pagina di login</h1>
                    <div id="profile-data">
                        <?php 
                            include_once ('User.php');

                            if(isset($_POST['submit'])){
                                $email = $_POST['email'];
                                $password = $_POST['password'];
                                $result = User::login($email, $password);
                                if($result) {
                                    $_SESSION['email'] = $email;
                                    $_SESSION['nickname'] = User::getNickname($email);
                                    header("Location: index.php";
                                    die();
                                } else {
                                    echo "<span>Credenziali errate, riprova!</span>";
                                }
                            } 
                        ?>
                        <form action="login.php" method="POST">
                            <label for="lemail">Email</label>
                            <input class="profile-input" type="text" id="lemail" name="email" placeholder="Email@some.boh" />
                            <label for="lpassword">Password</label>
                            <input class="profile-input" type="text" id="lpassword" name="password" placeholder="Password" />
                        
                            <input class="profile-input" name="submit" type="submit" value="Submit" />
                        </form>
                    </div>
                    <div>
                        Non sei ancora registrato? <br/>
                        Clicca <a href='registrazione.php'>qui</a> per creare un nuovo account.
                    </div>
                </div>
            </div>
            <?php
			    include_once ('footer.php');
		    ?>
    </body>
</html>