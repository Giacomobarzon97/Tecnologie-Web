<?php

    if(!isset($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }

    include_once('ArticleClass.php');
    include_once('Sidebar.php');
    include_once('Comments.php');
    include_once('User.php');

    if(!Article::checkIfArticleExist($_GET["id"])){
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
        <?php
            Sidebar::printSidebarIncludeHeader();
        ?>
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
                <div id="content">
                    <!--Inizio centratura articolo-->
                    <div class="article-content">
                    <?php
                        Article::printArticleHTML($_GET["id"]);
                    ?>
                    </div>
                    <hr />
                    <!--Inizio centratura commenti-->
                    <div id="comments-content">
                        <?php
                            if(isset($_POST['comment'])) {
                                User::addComment($_GET["id"], $_POST['comment-input'], $_SESSION['email']);
                            }
                            if(isset($_POST['vote-comment'])) {
                                User::voteComment($_POST['commentID'], $_SESSION['email'], $_POST['isLike']);
                            }
                            if(isset($_POST['delete-vote'])) {
                                User::removeVoteComment($_POST['commentID'], $_SESSION['email'], true);
                            }
                            if(isset($_POST['delete-comment'])) {
                                User::deleteComment($_SESSION['email'], $_POST['commentID']);
                            }
                            echo '<form action="Article.php?id='.$_GET["id"].'" method="POST" >';
                            Comments::printCommentInputZone($_SESSION['email']);
                            echo '</form>';
                            Comments::printAllComments($_GET["id"], $_SESSION['email']);
                        ?>
                    </div>
                    <!--Fine centratura commenti-->
                </div> <!--Chiusura div content-->
            </div> <!--Chiusura div main-->
            <?php
                include_once ('footer.php');
            ?>
        </div>
    </body>
</html>