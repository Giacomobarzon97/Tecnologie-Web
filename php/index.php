<?php
    include_once ('sessionManager.php');
    include_once ('Card.php');
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Homepage &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="DevSpace è una piattaforma che offre articoli 
        per conoscere il mondo dell'informatica." />
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
                <h1><label for="search-bar-textarea">Cerca articoli ed argomenti</label></h1>
				<div id="home-search-bar">
					<form form method="get" action="search.php">
						<fieldset id="search-bar">
							<p><input type="text" id="search-bar-textarea" name="search-term" required></p>
	                    	<p><input type="submit" value="Search"></p>
						</fieldset>
					</form>
				</div>
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
