<?php
    session_start();
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
		
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="./scripts.js"></script>
		
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
                            echo "Bentornato ".$_SESSION['nickname'];
                        } else {
                            include_once ('paginaNonDisponibile.php');
                            include_once ('footer.php');
                            die();
                        }
                    ?></h1>
                    <img src="./img/algorithm.jpg" alt="profile picture" />
                    <div id="profile-data">
                        <form action="/action_page.php">
                            <label for="fname">First Name</label>
                            <input class="profile-input" type="text" id="fname" name="firstname" placeholder="Your name.." />
                            <label for="lname">Last Name</label>
                            <input class="profile-input" type="text" id="lname" name="lastname" placeholder="Your last name.." />
                        
                            <label for="country">Country</label>
                            <select id="country" name="country">
                                <option value="australia">Australia</option>
                                <option value="canada">Canada</option>
                                <option value="usa">USA</option>
                            </select>
                        </form>
                        <form action="/action_page.php">
                            <label for="newpass">New Password</label>
                            <input class="profile-input" type="text" id="newpass" name="newpass" placeholder="New passoword.." />

                            <label for="newpassconf">Confirm new Password</label>
                            <input class="profile-input" type="text" id="newpassconf" name="newpassconf" placeholder="Confirm new Password" />
                        
                            <input class="profile-input" type="submit" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
            <?php 
                include_once ('footer.php');
            ?>
    </body>
</html>