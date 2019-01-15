<?php

    include_once ('sessionManager.php');
    include_once ('User.php');
    include_once ('Sidebar.php');
    include_once ('Card.php');
    include_once ("upload.php");

    //L'utente non è autorizzato
    if(!User::isAdmin($_SESSION['email'])){
        header("Location: index.php");
    }

    //aggiungi card
    if(isset($_POST['add-topic'])){
        $upload_File = upload($_FILES['upfile']['name'], $_FILES['upfile']['size'], $_FILES['upfile']['type'], $_FILES['upfile']['tmp_name']);
        if(isset($upload_File)){
            Card::insertTopic($_POST['titolo'], $_POST['descrizione'], $upload_File);
        }else{
            echo 'Si è verificato un errore...';
        }
    }

    //Rimuovi card
    if(isset($_POST['delete-topic'])){
        deleteFile($_POST['image-url']);
        Card::deleteTopic($_POST['topicID']);
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
                    Card::printInsertNewCardForm();
                ?>
                </div>
                <div id="content-article-body">
                    <h1>Oppure gestisci quelli già esistenti</h1>
                    <?php
                        Card::printAllCreatedCards();
                    ?>
                </div>
            </div> <!--Chiusura div main-->
            <?php
                include_once ('footer.php');
            ?>
        </div>
    </body>
</html>