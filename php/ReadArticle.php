<?php

    if(!isset($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }

    include_once('sessionManager.php');
    include_once('Article.php');
    include_once('Sidebar.php');
    include_once('Comments.php');
    include_once('User.php');

    if(!Article::checkIfArticleExist($_GET["id"])){
        header("Location: errore.php?errorCode=404");
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo Article::getArticleTitle($_GET['id']) ?> &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Article reading page" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>		
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        <?php
            if(isset($_SESSION['email'])) {
                if (isset($_POST['vote-comment'])) {
                    User::voteComment($_POST['commentID'], $_SESSION['email'], $_POST['isLike'], $_GET["id"]);
                }
                if (isset($_POST['delete-vote'])) {
                    User::removeVoteComment($_POST['commentID'], $_SESSION['email'], $_GET["id"], true);
                }
                if (isset($_POST['delete-comment'])) {
                    User::deleteComment($_SESSION['email'], $_POST['commentID']);
                }
            }

            Sidebar::printSidebarIncludeHeader();
        ?>
    </head>
    <body>
        <button onclick="topFunction()" id="retTop" title="Torna su"></button>
        <div id="mobile-sidebar-mask">
        </div>
        <div id="sidebar-wrapper">
        <?php
            Sidebar::printArticleSidebar($_GET["id"]);
        ?>
        </div>
        <div id="rightSideWrapper">
            <?php
                Sidebar::printNavbar();
            ?>
            <div id="main">
                <!--Inizio centratura articolo-->
                <div class="article-content">
                <?php
                    Article::printArticleHTML($_GET["id"]);
                ?>
                </div>
                <!--Inizio centratura commenti-->
                <div id="comment-section">
                    <?php
                        if(isset($_POST['comment'])) {
                            $result = User::addComment($_GET["id"], $_POST['comment-input'], $_SESSION['email']);
                            if($result->getIsError()){
                                echo '<ul class="regform-errorbox">';
                                echo $result->getMessage();
                                echo "</ul>";
                            }
                        }
                        Comments::printCommentInputZone($_SESSION['email']);
                        Comments::printAllComments($_GET["id"], $_SESSION['email']);
                    ?>
                </div>
                <!--Fine centratura commenti-->
            </div> <!--Chiusura div main-->
            <noscript>
                <?php
                Sidebar::printNoJsNavbar();
                echo '<div id="nojs-sidebar-wrapper">';
                Sidebar::printNoJsSidebarSearchbox();
                Sidebar::printArticleSidebar($_GET["id"], true);
                echo '</div>';
                ?>
            </noscript>
            <?php
                include_once ('footer.php');
                Footer::printDefaultFooterWithJSError();
                Sidebar::openSidebarEntryArticle($_GET["id"]);
            ?>
        </div>
    </body>
</html>
