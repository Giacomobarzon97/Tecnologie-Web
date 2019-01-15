<?php

    if(!isset($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }

    include_once ('sessionManager.php');
    include_once ('Subtopics.php');
    include_once ('Sidebar.php');
    include_once ('Article.php');
    if(!Subtopics::checkIfTopicExists($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }

    if(isset($_POST["delete-article"])){
        Article::deleteArticle($_POST["articleID"]);
    }

    if(isset($_POST["add-subtopic"])){
        Subtopics::insertSubtopic($_POST["title"], $_POST["description"], $_POST["topicID"]);
    }

    if(isset($_POST["delete-subtopic"])){
        Subtopics::deleteSubtopic($_POST["subtopicID"]);
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
            Sidebar::printSidebar($_GET["id"]);
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
                    Subtopics::printInsertSubtopicForm($_SESSION['email'], $_GET["id"]);
                ?>
                </div>
                <div id="content-article-body">
                    <h1>Contenuto del corso</h1>
                    <ul>
                    <?php
                        Subtopics::printSubtopicsList($_GET["id"], $_SESSION['email']);
                    ?>
                    </ul>
                </div>
            </div>
            <?php
                include_once ('footer.php');
                Sidebar::openSidebarEntry($_GET["id"]);
            ?>
        </div>
    </body>
</html>
