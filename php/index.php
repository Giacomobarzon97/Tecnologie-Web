<?php
    include_once ('sessionManager.php');
    include_once ('Card.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Homepage &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="DevSpace is a platform that offers articles about 
        computer science world." />
        <meta name="keywords" content="computer, science, development, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>		
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="./style/style.css" />
        <link rel="stylesheet" type="text/css" href="./style/print.css" media="print"/>
        <script src="./script/scripts.js"></script>
        
    </head>
    
    <body>
        <button onclick="topFunction()" id="retTop" title="Back to the top"></button>
        <?php
            include_once('navbar.php');
            SimpleNavbar::printSimpleNavbar();
        ?>
        <div id="header">
            <h1>DevSpace</h1>
        </div>
        <div id="main">
            <div id="content">
                <div id="introduction">
                    <p>
						Dev Space is a project with the purpose of collect computer science tutorials for developers and others that want to start their trip in CS world. Contents are target to give to our users a base, a start point of principal topics.</p>
					<br/>
					<p>
						Reach goals, learn new things, ask questions to other users and get answers that solve your doubts. Say your opinion, discuss, become part of our community.
                    </p>
                </div>
            </div>
        
            <div class="grid">
                
				<div id="home-search-bar">
					<form method="get" action="search.php">
						<fieldset class="search-bar">
							<p>
                                <label for="search-bar-textarea">Search for topics and articles</label>
                                <input type="text" id="search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_!.'()-]+( [a-zA-Z0-9_!.'()-]+)*$" required />
                            </p>
	                    	<p>
                                <input type="submit" value="Search" />
                            </p>
						</fieldset>
					</form>
				</div>
                <h1>Topics</h1>
                <?php
                    Card::printAllCards();
                ?>
            </div>
        </div>
        <?php
            echo '<noscript>';
            SimpleNavbar::printSimpleNavbar(true);
            echo '</noscript>';
        ?>
        <?php
            include_once ('footer.php');
            Footer::printDefaultFooterWithLargeJSError();
        ?>
    </body>
</html>
