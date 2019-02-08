<?php
    include_once ('sessionManager.php');

    session_destroy();
    header("Location:".$_SESSION["lastVisitedPage"]);
?>

