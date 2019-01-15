<?php

    include_once('sessionManager.php');
    include_once('Sidebar.php');
    include_once('Subtopics.php');
    include_once('Article.php');

    if(isset($_POST['submit']))
	{
        Article::insertArticleInTable($_POST['title'], $_POST['article-input'], $_SESSION['email'], $_POST['subtopicID']);
        header("location: ArticleLinks.php?id=".Subtopics::getTopicIDFromSubtopic($_POST['subtopicID']));
    }

    if(!Subtopics::checkIfSubtopicExists($_GET['subtopicID']) && !isset($_POST['submit']))
    {
        header("location: index.php");
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

        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />

		<link rel="stylesheet" type="text/css" href="print.css" media="print"/>
		<script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        <?php
            Sidebar::printSidebarIncludeHeader();
        ?>
    </head>
    <body>
        <div id="mobile-sidebar-mask">
        </div>
        <div id="sidebar-wrapper">
        <?php
            Sidebar::printSidebar($_GET['topicID'], $_GET['subtopicID'], true);
        ?>
        </div>
        <div id="rightSideWrapper">
            <?php
                Sidebar::printNavbar();
            ?>
            <div id="main">
                <div id="insert-article-error-box"></div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="write-article-form">
	                <h1>Scrivi un nuovo articolo</h1>
	                <ul id="article-info">
                        <?php
	                	    echo '<li>Argomento: '.Subtopics::getTopicTitle($_GET['topicID']).'</li>';
                            echo '<li>Sottoargomento: '.Subtopics::getSubtopicTitle($_GET['subtopicID']).'</li>';
                        ?>
	                </ul>
                    <fieldset>
                        <input type="hidden" name="subtopicID" value="<?php echo $_GET['subtopicID'] ?>" />
                        <p>
                            <h2>Inserisci il titolo per il tuo articolo</h2>
                            <input type="text" name="title" required id="title" placeholder="Titolo dell'articolo">
                        </p>
                        <p>
                            <h2>Scrivi il testo del tuo articolo</h2>
                            <textarea name="article-input" required rows="10" cols="100" id="new-article-content"></textarea>
                        </p>
                        <p>Tag HTML supportati</p>
                        <input type="submit" value="Invia" name="submit"/> 
                    </fieldset>                 	
	            </form>
            </div>
            <?php
                include_once ('footer.php');
                Sidebar::openSidebarEntry($_GET["topicID"]);
            ?>
        </div>
    </body>
</html>
