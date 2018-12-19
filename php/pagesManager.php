<?php
    /*session_start();
    if(!empty($_SESSION['visited_pages'])) {
        $_SESSION['visited_pages']['current'] = $_SERVER['REQUEST_URI'];
        $_SESSION['visited_pages']['prev'] = $_SESSION['visited_pages']['current'];
    } else {
        $_SESSION['visited_pages']['prev'] = 'No previous page';
    }*/
    $stack = NULL;
    if(!isset($stack)) {
        $stack = array();
    }
    array_push($stack, $_SERVER['REQUEST_URI']);

    function getPreviousPage() {
        array_pop($stack);
        echo $stack;
        return array_pop($stack);
    }
    
?>