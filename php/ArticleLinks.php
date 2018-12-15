<?php
	include_once('Subtopics.php');
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
		
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" type="text/css" href="print.css" media="print"/>
		<script src="./scripts.js"></script>
		
	</head>
    <body>
    <?php
		include_once('navbar.php');
	?>
    <div id="main">
        <div id="content-article-introduction">
        <?php
            Subtopics::printTopicIntroduction(1);
        ?>
        </div>
        <div id="content-article-body">
        <h1>Contenuto del corso</h1>
            <ul>
            <?php
                Subtopics::printSubtopicsList(1);
            ?>
            </ul>
        </div>
	</div>
    <?php
		include_once ('footer.php');
	?>
    </body>
</html>