<?php
    include_once ("User.php");
    class SimpleNavbar
    {
        static function printSimpleNavbar($isNoJsVersion = false)
        {
            if(!$isNoJsVersion) {
                echo '<div id="nav-full">';

                if($_SESSION["breadcrumb"] !== "index.php"){
                    echo '<a href="index.php"><img src="img/logo.png" alt="Dev Space" id="nav-logo"></a>';
                } else {
                    echo '<img src="img/logo.png" alt="Dev Space" id="nav-logo">';
                }
            }

            if($isNoJsVersion){
                echo '<ul id="nojs-menu">';
                echo '<li><h1>Menu</h1></li>';
            }else {
                echo '<ul id="menu">';
            }

            if (isset($_SESSION['email'])) {

                if ($_SESSION["breadcrumb"] == "index.php") {
                    echo "<li class='current-menu-entry'>Home</li>
            ";
                } else {
                    echo "<li><a href='index.php'>Home</a></li>
            ";
                }
                if ($_SESSION["breadcrumb"] == "profile.php") {
                    echo "<li class='current-menu-entry'>Profile</li>
            ";
                } else {

                    echo "<li><a href='profile.php'>Profile</a></li>
            ";
                }

                if (User::isAdmin($_SESSION['email'])) {
                    if ($_SESSION["breadcrumb"] == "adminTools.php") {
                        echo "<li class='current-menu-entry'>Admin tools</li>
                ";
                    } else {
                        echo "<li><a href='adminTools.php'>Admin tools</a></li>
                ";
                    }
                }
                echo "<li><a href='logout.php'>Logout</a></li>
        ";
            } else {
                if ($_SESSION["breadcrumb"] == "index.php") {
                    echo "<li class='current-menu-entry'>Home</li>
            ";
                } else {
                    echo "<li><a href='index.php'>Home</a></li>
            ";
                }
                if ($_SESSION["breadcrumb"] == "registrazione.php") {
                    echo "<li class='current-menu-entry'>Create a new account</li>
            ";
                } else {
                    echo "<li><a href='registrazione.php'>Create a new account</a></li>
            ";
                }
                if ($_SESSION["breadcrumb"] == "login.php") {
                    echo "<li class='current-menu-entry'>Login</li>
            ";
                } else {
                    echo "<li><a href='login.php'>Login</a></li>
            ";
                }
            }
            if ($_SESSION["breadcrumb"] == "about.php") {
                echo "<li class='current-menu-entry'>About</li>
        ";
            } else {
                echo "<li><a href='about.php'>About</a></li>
        ";
            }

            echo '</ul>';

            if(!$isNoJsVersion) {
                echo '<img src="img/hamburger.svg" alt="menu-icon" id="nav-menu-icon"/>
                    <noscript>
                        <a href="#nojs-menu"><img src="img/hamburger.svg" alt="hamburger icon" id="nojs-hamburger"/></a>
                    </noscript>
                    </div>';
            }
        }
    }
?>
        
