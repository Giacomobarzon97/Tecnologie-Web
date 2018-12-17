<?php
    if(!isset($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }
    include_once('Subtopics.php');
    include_once('Sidebar.php');
    if(!Subtopics::checkIfTopicExists($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }
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
    <div id="mobile-sidebar-mask">
    </div>
	<div id="sidebar-wrapper">
    <?php
        Sidebar::printSidebar();
    ?>
    </div>
    <div id="rightSideWrapper">
        <?php
            Sidebar::printNavbar();
        ?>
        <div id="main">
            <div id="content-article-introduction">
            <?php
                Subtopics::printTopicIntroduction($_GET["id"]);
                Subtopics::printInsertSubtopicForm($_SESSION['email']);
            ?>
            </div>
            <div id="content-article-body">
            <h1>Contenuto del corso</h1>
                <ul>
                <?php
                    Subtopics::printSubtopicsList($_GET["id"]);
                ?>
                </ul>
            </div>
        </div>
        <?php
		    include_once ('footer.php');
	    ?>
    </div>
    </body>
</html>