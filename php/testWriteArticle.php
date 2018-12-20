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
                <h1>pell</h1>
                <div id="editor" class="pell"></div>
                <h3>Invia l'articolo</h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="html-generated" name="html-input" value="" />
                    <input type="submit" value="invia" name="submit"/>
                </form>
                <script>
                var editor = window.pell.init({
                    element: document.getElementById('editor'),
                    defaultParagraphSeparator: 'p',

                    onChange: html => document.getElementById('html-generated').value = html,
                })
                </script>
        </div>
    </body>
</html>
