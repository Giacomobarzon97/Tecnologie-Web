<?php

    include_once ('sessionManager.php');
    include_once ('User.php');
    include_once ('Sidebar.php');
    include_once ('Card.php');
    include_once ("upload.php");

    //L'utente non è autorizzato
    if(!isset($_SESSION['email'])) {
        header("Location: errore.php?errorCode=paginaNonDisponibile");
    }

    if(!User::isAdmin($_SESSION['email'])){
        header("Location: errore.php?errorCode=nonAdmin");
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Topics management &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Management page for subtopics" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
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
        <button onclick="topFunction()" id="retTop" title="Back to the top"></button>
        <div id="mobile-sidebar-mask">
        </div>
        <div id="sidebar-wrapper">
        <?php
            /*
             * This code is here because we need to insert/remove a card first, before executing Sidebar::printSidebar
             * THis because doing otherwise result in printing in the sidebar something that has been deleted
             * Of course i can move this over <html> but it's basically the same, is small enough to stay here
             */
            $nickname = unserialize($_SESSION['userInfo'])->nickname;
            $banned = false;
            if(User::isBanned($nickname)) {
                $banned = true;
            }else{
                //Delete card
                $topicToDelete = NULL;
                if(isset($_POST['delete-topic'])) {
                    $topicToDelete = Card::getTopicRow($_POST['topicID']);
                    if($topicToDelete!=NULL) {
                        deleteFile($topicToDelete['ImageLink']);
                        Card::deleteTopic($_POST['topicID']);
                    }
                }
                //Add card
                if(isset($_POST['add-topic'])) {
                    $upload_result = upload($_FILES['upfile']['name'], $_FILES['upfile']['size'], $_FILES['upfile']['type'], $_FILES['upfile']['tmp_name']);
                    if(!$upload_result->getIsError()){
                        $imageLink = str_replace(" ","%20", $upload_result->data_message);
                        $create_result = Card::insertTopic($_POST['titolo'], $_POST['descrizione'], $imageLink);
                    }
                }
            }
            Sidebar::printSidebar(NULL);
        ?>
        </div>
        <div id="rightSideWrapper">
            <?php
                Sidebar::printNavbar();
            ?>
            <div id="main">
                <div id="content-article-introduction">
                <?php
                    echo '<div id="arguments-error-box-insert-card">';

                    if($banned) {
                        echo '<ul class="regform-errorbox">';
                        echo '<li>Your account has been suspended, you can\'t use admin tools anymore. In order to get back your admin role
                            another user have to remove your suspension.</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div> <!--Chiusura div main-->';
                    }else{
                        //Rimuovi card
                        if(isset($_POST['delete-topic'])){
                            if($topicToDelete==NULL){
                                echo '<ul class="regform-errorbox">';
                                echo '<li>An error occurred deleting the topic, you probably changed something...</li>';
                                echo '</ul>';
                            }else {
                                echo '<ul class="regform-successbox">';
                                echo '<li>Topic deleted successfully</li>';
                                echo '</ul>';
                            }
                        }

                        //aggiungi card
                        if(isset($_POST['add-topic'])){

                            if($upload_result->getIsError()){
                                echo '<ul class="regform-errorbox">';
                                echo $upload_result->getMessage();
                                echo '</ul>';
                            }else{
                                if($create_result->getIsError()){
                                    echo '<ul class="regform-errorbox">';
                                    echo $create_result->getMessage();
                                    echo '</ul>';
                                }else {
                                    echo '<ul class="regform-successbox">';
                                    echo '<li>Topic created successfully</li>';
                                    echo '</ul>';
                                }
                            }

                        }
                        echo '</div>';

                        Card::printInsertNewCardForm();

                        echo '</div>
                        <div id="content-article-body">
                            <h1>Or manage existing ones</h1>';
                                Card::printAllCreatedCards();
                        echo '</div>';

                        echo '</div> <!--Chiusura div main-->';

                        include_once ('footer.php');
                        Footer::printDefaultFooterWithJSError();
                    }
            ?>
        </div>
    </body>
</html>
