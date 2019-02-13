<?php
include_once("User.php");

class SimpleNavbar
{

    static function printNoJSWarning(){
        echo '<div id="nojs-messagebox-full">ATTENTION - With JavaScript disabled some features may not be available or may not work properly!</div>';
    }

    static function printSimpleNavbar($isNoJsVersion = false)
    {
        if (!$isNoJsVersion) {
            echo '<div id="nav-full">';

            if ($_SESSION["breadcrumb"] !== "index.php") {
                echo '<a href="index.php"><img src="img/logo.png" alt="Logo Dev Space" id="nav-logo"></a>';
            } else {
                echo '<img src="img/logo.png" alt="Logo Dev Space" id="nav-logo">';
            }
        }

        if ($isNoJsVersion) {
            echo '<ul id="nojs-menu">';
            echo '<li><h1>Menu</h1></li>';
        } else {
            echo '<ul id="menu">';
        }

        if (isset($_SESSION['email'])) {

            if ($_SESSION["breadcrumb"] == "index.php") {
                echo "<li class='current-menu-entry'>Home</li>
            ";
            } else {
                if($isNoJsVersion){
                    echo "<li><a href='index.php'>Home</a></li>";
                }else{
                    echo "<li><a href='index.php' accesskey='h'>Home</a></li>";
                }
            }
            if ($_SESSION["breadcrumb"] == "profile.php") {
                echo "<li class='current-menu-entry'>Profile</li>
            ";
            } else {
                if($isNoJsVersion) {
                    echo "<li><a href='profile.php'>Profile</a></li>";
                }else{
                    echo "<li><a href='profile.php' accesskey='p'>Profile</a></li>";
                }
            }

            if (User::isAdmin($_SESSION['email'])) {
                if ($_SESSION["breadcrumb"] == "adminTools.php") {
                    echo "<li class='current-menu-entry'>Admin tools</li>
                ";
                } else {
                    if($isNoJsVersion) {
                        echo "<li><a href='adminTools.php'>Admin tools</a></li>";
                    }else{
                        echo "<li><a href='adminTools.php' accesskey='t'>Admin tools</a></li>";
                    }

                }
            }
            if($isNoJsVersion) {
                echo "<li><a href='logout.php'>Logout</a></li>";
            }else {
                echo "<li><a href='logout.php' accesskey='l'>Logout</a></li>";
            }
        } else {
            if ($_SESSION["breadcrumb"] == "index.php") {
                echo "<li class='current-menu-entry'>Home</li>
            ";
            } else {
                if($isNoJsVersion){
                    echo "<li><a href='index.php'>Home</a></li>";
                }else{
                    echo "<li><a href='index.php' accesskey='h'>Home</a></li>";
                }
            }
            if ($_SESSION["breadcrumb"] == "registrazione.php") {
                echo "<li class='current-menu-entry'>Create a new account</li>
            ";
            } else {
                if($isNoJsVersion){
                    echo "<li><a href='registrazione.php'>Create a new account</a></li>";
                }else {
                    echo "<li><a href='registrazione.php' accesskey='c'>Create a new account</a></li>";
                }
            }
            if ($_SESSION["breadcrumb"] == "login.php") {
                echo "<li class='current-menu-entry'>Login</li>
            ";
            } else {
                if($isNoJsVersion){
                    echo "<li><a href='login.php'>Login</a></li>";
                }else {
                    echo "<li><a href='login.php' accesskey='l'>Login</a></li>";
                }
            }
        }
        if ($_SESSION["breadcrumb"] == "about.php") {
            echo "<li class='current-menu-entry'>About</li>
        ";
        } else {
            if($isNoJsVersion){
                echo "<li><a href='about.php'>About</a></li>";
            }else {
                echo "<li><a href='about.php' accesskey='a'>About</a></li>";
            }
        }

        echo '</ul>';

        if (!$isNoJsVersion) {
            echo '<img src="img/hamburger.svg" alt="menu-icon" id="nav-menu-icon"/>
                    <noscript>
                        <a href="#nojs-menu"><img src="img/hamburger.svg" alt="hamburger icon" id="nojs-menu-icon"/></a>
                    </noscript>
                    </div>';
        }
    }
}

?>
        
