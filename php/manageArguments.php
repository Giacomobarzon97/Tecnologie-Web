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

    if(User::isBanned($_SESSION['email'])){
        header("Location: errore.php?errorCode=bannanto");
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
        <title>Gestione Argomenti &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina di gestione dei macroargomenti argomenti" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>		
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        
        <?php
        Sidebar::printSidebarIncludeHeader();
        ?>
    </head>
    <body>
        <button onclick="topFunction()" id="retTop" title="Torna su"></button>
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
                    //aggiungi card
                    if(isset($_POST['add-topic'])){
                        $result = upload($_FILES['upfile']['name'], $_FILES['upfile']['size'], $_FILES['upfile']['type'], $_FILES['upfile']['tmp_name']);
                        echo '<div id="arguments-error-box-insert-card">';
                        if($result->getIsError()){
                            echo '<ul class="regform-errorbox">';
                            echo $result->getMessage();
                            echo '</ul>';
                        }else{
                            $result = Card::insertTopic($_POST['titolo'], $_POST['descrizione'], $result->data_message);
                            if($result->getIsError()){
                                deleteFile($result->data_message);
                                echo '<ul class="regform-errorbox">';
                                echo $result->getMessage();
                                echo '</ul>';
                            }else {
                                echo '<ul class="regform-successbox">';
                                echo '<li>Topic created successfully</li>';
                                echo '</ul>';
                            }
                        }
                        echo '</div>';
                    }

                    Card::printInsertNewCardForm();
                ?>
                </div>
                <div id="content-article-body">
                    <h1>Or manage existing ones</h1>
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