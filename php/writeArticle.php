<?php

    include_once('sessionManager.php');
    include_once('Sidebar.php');
    include_once('Subtopics.php');
    include_once('Article.php');
    include_once('User.php');

    if(!isset($_SESSION['email'])) {
        header("Location: errore.php?errorCode=paginaNonDisponibile");
    }

    if(!User::isAdmin($_SESSION['email'])){
        header("Location: errore.php?errorCode=nonAdmin");
    }

    if(User::isBanned($_SESSION['email'])){
        header("Location: errore.php?errorCode=bannanto");
    }

    if(isset($_POST['create-article']))
    {
        $return_value = Article::insertArticleInTable($_POST['title'], $_POST['article-input'], $_SESSION['email'], $_POST['subtopicID']);
        if($return_value == NULL) {
            header("location: ArticleLinks.php?id=" . Subtopics::getTopicIDFromSubtopic($_POST['subtopicID']));
        }
    }
    if(isset($_POST['edit-article']))
    {
        $return_value = Article::editArticle($_GET['articleID'], $_POST['title'], $_POST['article-input']);
        if($return_value == NULL) {
            header("location: ArticleLinks.php?id=" . Subtopics::getTopicIDFromSubtopic($_POST['subtopicID']));
        }
    }

    if(!Subtopics::checkIfSubtopicExists($_GET['subtopicID']) && !isset($_POST['submit']))
    {
        header("Location: errore.php?errorCode=404");
    }
    if(isset($_GET['articleID']) && !Article::checkIfArticleExist($_GET['articleID'])){
        header("Location: errore.php?errorCode=404");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Scrittura Articolo &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Page to write a new article" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="theme-color" content="#F5F5F5" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>			
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="./style/style.css" />
        <link rel="stylesheet" type="text/css" href="./style/print.css" media="print"/>
        
        <script src="./script/scripts.js"></script>
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
                <div id="insert-article-error-box">
                    <?php
                        if(isset($_POST['create-article']) || isset($_POST['edit-article'])){
                            if(isset($return_value) && $return_value->getIsError()){
                                echo '<ul class="regform-errorbox">';
                                echo '<li>'.$return_value->getMessage().'</li>';
                                echo '</ul>';
                            }
                        }
                    ?>
                </div>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="write-article-form">
                    <?php
                        if(isset($_GET['articleID'])){
                            echo '<h1>Edit an article</h1>';
                        }else{
                            echo '<h1>Write a new article</h1>';
                        }
                    ?>
                    <ul id="article-info">
                        <?php
                            echo '<li>Topic: <a href="ArticleLinks.php?id='.$_GET['topicID'].'">'.Subtopics::getTopicTitle($_GET['topicID']).'</a></li>';
                            echo '<li>Subtopic: <a href="ArticleLinks.php?id='.$_GET['topicID'].'#subtopic_'.$_GET['subtopicID'].'">'.Subtopics::getSubtopicTitle($_GET['subtopicID']).'</a></li>';
                            if(isset($_GET['articleID'])){
                                $articleInfo = Article::getArticleRowFromId($_GET['articleID']);
                                echo '<li>You are editing the article: <a href="ReadArticle.php?id='.$articleInfo['Id'].'" target="_blank">'.$articleInfo['Title'].'</a></li>';
                            }
                        ?>
                    </ul>
                    <fieldset>
                        <input type="hidden" name="subtopicID" value="<?php echo $_GET['subtopicID'] ?>" />
                        <p>
                            <?php
                                if(isset($_POST['create-article']) || isset($_POST['edit-article'])){
                                    echo '<label for="title">Edit the title for your article</label>';
                                    echo '<input type="text" name="title" required id="title" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" placeholder="Title of the article" value="'.$_POST['title'].'">';
                                }else {
                                    if (isset($_GET['articleID'])) {
                                        echo '<label for="title">Edit the title for your article</label>';
                                        echo '<input type="text" name="title" required id="title" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" placeholder="Title of the article" value="' . $articleInfo['Title'] . '">';
                                    } else {
                                        echo '<label for="title">Enter the title for your article</label>';
                                        echo '<input type="text" name="title" required id="title" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" placeholder="Title of the article">';
                                    }
                                }
                            ?>
                        </p>
                        <p>
                            <?php
                                if(isset($_POST['create-article']) || isset($_POST['edit-article'])){
                                    echo '<label for="new-article-content">Edit the text of your article</label>';
                                    echo '<textarea name="article-input" required rows="10" cols="100" id="new-article-content">' . $_POST['article-input'] . '</textarea>';
                                }else {
                                    if (isset($_GET['articleID'])) {
                                        echo '<label for="new-article-content">Edit the text of your article</label>';
                                        echo '<textarea name="article-input" required rows="10" cols="100" id="new-article-content">' . $articleInfo['HTMLCode'] . '</textarea>';
                                    } else {
                                        echo '<label for="new-article-content">Write the text of your article</label>';
                                        echo '<textarea name="article-input" required rows="10" cols="100" id="new-article-content"></textarea>';
                                    }
                                }
                            ?>
                        </p>
                        <p>Supported HTML tags: <?php echo htmlspecialchars(Article::$allowed_content_tags) ?></p>
                        <?php
                            if(isset($_GET['articleID'])){
                                echo '<input type="submit" value="Edit article" name="edit-article"/>';
                                echo '<a href="ArticleLinks.php?id='.$_GET['topicID'].'">Cancel article edit and go back</a>';
                            }else{
                                echo '<input type="submit" value="Create Article" name="create-article"/>';
                            }
                        ?>
                    </fieldset>                 	
                </form>
            </div>
            <?php
                include_once ('footer.php');
                Footer::printDefaultFooterWithJSError();
                Sidebar::openSidebarEntry($_GET["topicID"]);
            ?>
        </div>
    </body>
</html>
