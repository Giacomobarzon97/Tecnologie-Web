<?php
    session_start();
    include_once ("User.php");
    include_once ('pagesManager.php');
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
                <h1>Nome sito</h1>
            </div>

            <div id="profile-info">
                <div id="profile-content">
                    <h1><?php 
                        if(isset($_SESSION['nickname'])) {
                            echo "Bentornato, ".$_SESSION['nickname'];
                        } else {
                            header("Location: errore.php?errorCode=paginaNonDisponibile");
                            die();
                        }
                    ?></h1>
                    
                    <div id="profile-data">
                        <form action="/action_page.php">
                            <label for="fname">First Name</label>
                            <input class="profile-input" type="text" id="fname" name="firstname" placeholder="Your name.." />
                            <label for="lname">Last Name</label>
                            <input class="profile-input" type="text" id="lname" name="lastname" placeholder="Your last name.." />
                        
                        </form>
                        <form action="/action_page.php">
                            <label for="newpass">New Password</label>
                            <input class="profile-input" type="text" id="newpass" name="newpass" placeholder="New passoword.." />

                            <label for="newpassconf">Confirm new Password</label>
                            <input class="profile-input" type="text" id="newpassconf" name="newpassconf" placeholder="Confirm new Password" />
                        
                            <input class="profile-input" type="submit" value="Submit" />
                        </form>

                        <form action="profile.php" method="POST" >
                            <?php 
                                if(isset($_POST['delete_account'])) {
                                    User::deleteAccount($_SESSION['email']);
                                    session_destroy();
                                    header("Location: index.php");
                                }
                            ?>
                            <input class="profile-input" name="delete_account" type="submit" value="Elimina il tuo account" />
                        </form>
                    </div>
                </div>
            </div>
            <?php 
                include_once ('footer.php');
            ?>
    </body>
</html>