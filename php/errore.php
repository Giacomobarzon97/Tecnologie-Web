<?php
	session_start();
	include_once('Card.php');
	include_once ('pagesManager.php');
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<title>WebSite-Home</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="title" content="progetto tecc-web" />
        <meta name="description" content="computer science topics" />
        <meta name="keywords" content="computer science" />
        <meta name="language" content="italian it" />
		<meta name="author" content="" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>		
		
		<link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
		<link rel="stylesheet" type="text/css" href="print.css" media="print"/>
		<script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
		
	</head>
	
	<body>	
		<?php
            include_once('navbar.php');
        ?>
        <div id="header">
			<h1>NOME SITO</h1>
		</div>
        <?php
            include_once ('Errori.php');
            if(isset($_GET['errorCode']) && $_GET['errorCode'] != "") {
                echo $errors[$_GET['errorCode']];
            } else{
                echo $errors['404'];
            }
            
			include_once ('footer.php');
		?>
	</body>
</html>
