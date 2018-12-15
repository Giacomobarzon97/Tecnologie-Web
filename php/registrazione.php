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
			<h1>NOME SITO</h1>
		</div>
            <div id="profile-info">
                <div id="profile-content">
                    <h1>Pagina di registrazione</h1>
                    <span>Informazioni per la registrazione</span>
                    <div id="profile-data">
                    <?php 
                        include_once ('User.php');

                        if(isset($_POST['submit'])){ //check if form was submitted
                            $email = $_POST['email'];
                            $nickname = $_POST['nickname'];
                            $name = $_POST['name'];
                            $surname = $_POST['surname'];
                            $password = $_POST['password'];
                            $message = User::registration($email, $nickname, $password, $name, $surname);
                            echo "<div>".$message."</div>";
                        } 
                    ?>
                        <form action="registrazione.php" method="POST">
                            <label for="lemail">Email</label>
                            <input class="profile-input" type="text" id="lemail" name="email" placeholder="Email@some.boh" />
                            <label for="lnickname">Nickname</label>
                            <input class="profile-input" type="text" id="lnickname" name="nickname" placeholder="Nickname" />
                            <label for="lname">Nome</label>
                            <input class="profile-input" type="text" id="lname" name="name" placeholder="Nome" />
                            <label for="lsurname">Cognome</label>
                            <input class="profile-input" type="text" id="lsurname" name="surname" placeholder="Cognome" />
                            <label for="lpassword">Password</label>
                            <input class="profile-input" type="text" id="lpassword" name="password" placeholder="Password" />
                        
                            <input class="profile-input" name="submit" type="submit" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
            <?php
			    include_once ('footer.php');
		    ?>
    </body>
</html>