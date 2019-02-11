<?php
    session_start();
    include_once('Card.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Error &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Error handling page" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta name="theme-color" content="#F5F5F5" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        
    </head>
    
    <body>	
        <?php
            include_once ('Errori.php');
            
            if(isset($_GET['errorCode']) && $_GET['errorCode'] != "") {
                echo $errors[$_GET['errorCode']];
            } else{
                echo $errors['404'];
            }
            echo "<img src='img/404.png' alt='404 error image' id='error_404_image' />";
        ?>
        
    </body>
</html>
