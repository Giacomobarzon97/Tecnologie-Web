<?php

    include_once('sessionManager.php');
    include_once('Sidebar.php');

    if(isset($_POST['submit']))
	{
        echo $_POST['html-input'];
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

        <link rel="stylesheet" type="text/css" href="pell/pell.min.css">
        <script src="pell/pell.min.js"></script>

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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <h1>Inserisci un nuovo articolo</h1>
                <h2>Titolo dell'articolo</h2>
                    <label for="title">Titolo dell'articolo:</label>
                    <input type="text" name="title" id="title" placeholder="Scrivi il titolo dell'articolo..." />
                    <br />
                <h2>Contenuto dell'articolo</h2>
                    <div id="editor" class="pell"></div>
                    <input type="hidden" id="html-generated" name="html-input" value="" />
                    <script>
                        var editor = window.pell.init({
                            element: document.getElementById('editor'),
                            defaultParagraphSeparator: 'p',

                            onChange: html => document.getElementById('html-generated').value = html,
                        })
                    </script>
                    <noscript> <!--Javascript non attivo-->
                        <h3>Inserisci il test del tuo articolo (I tag HTML sono supportati)</h3>
                        <textarea name="no-js-input" rows="10" cols="100"></textarea>
                    </noscript>
                <h2>Invia l'articolo</h2>
                    <input type="submit" value="invia" name="submit"/>
                </form>
            </div>
        </div>
    </body>
</html>
