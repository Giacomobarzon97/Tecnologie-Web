<?php
    session_start();
    include_once ("upload.php");
?>  
<!DOCTYPE html>
<html lang="it">
	<head>
		<title>WebSite-Profile</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="title" content="progetto tec-web" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="language" content="italian it" />
		<meta name="author" content="" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
		<link rel="stylesheet" type="text/css" href="print.css" media="print"/>
		<script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
		
    </head>

    <body>
    <form enctype="multipart/form-data" action="uploadImageTest.php" method="POST">
        Send this file: <input name="upfile" type="file" />
        <input type="submit" value="Send File" />
        <?php
            upload($_FILES['upfile']['name'], $_FILES['upfile']['size'],
            $_FILES['upfile']['type'], $_FILES['upfile']['tmp_name']);
        ?>
    </form>
 
	</body>
</html>