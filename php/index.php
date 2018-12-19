<?php
	session_start();
	include_once ('pagesManager.php');
	include_once ('Card.php');
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
		<div id="main">
			<div id="content">
				<div id="introduction">
						<p>
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut odio. Nam sed est. Nam a risus et est iaculis adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ut justo. In tincidunt viverra nisl. Donec dictum malesuada magna. Curabitur id nibh auctor tellus adipiscing pharetra. Fusce vel justo non orci semper feugiat. Cras eu leo at purus ultrices tristique.
						</p>
						<br/>
						<p>
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut odio. Nam sed est. Nam a risus et est iaculis adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ut justo. In tincidunt viverra nisl. Donec dictum malesuada magna. Curabitur id nibh auctor tellus adipiscing pharetra. Fusce vel justo non orci semper feugiat. Cras eu leo at purus ultrices tristique.
						</p>
				</div>
			</div>
		
			<div class="grid">
				<h1>Argomenti</h1>
				<?php
					Card::printAllCards();
				?>
			</div>
		</div>
		<?php
			include_once ('footer.php');
		?>
	</body>
</html>
