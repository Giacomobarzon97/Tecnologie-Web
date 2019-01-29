<?php
	session_start();
	include_once('Card.php');
?>
<!DOCTYPE html>
<html lang="it">
	<head>
	<title>Errore &#124; DevSpace</title>
		<meta charset="UTF-8">
        <meta name="description" content="Pagina gestione errori" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
		<meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
		<meta name="theme-color" content="#F5F5F5" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
		
		<link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
		<link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
		<script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
		
	</head>
	
	<body>	
        <?php
			
            include_once ('Errori.php');
            if(isset($_GET['errorCode']) && $_GET['errorCode'] != "") {
                echo $errors[$_GET['errorCode']];
            } else{
                echo $errors['404'];
			}
			echo "<img src='img/404.jpg' alt='Immagine errore' style='display: block;
			margin-left: auto;
			margin-right: auto;
			padding-top:10%;
			width: 50%;' />";
		?>
		
	</body>
</html>
