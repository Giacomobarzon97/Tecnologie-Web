<div id="nav-full">
    <?php 
        if($_SESSION["breadcrumb"] !== "index.php"){
            echo '<a href="index.php"><img src="img/logo.png" alt="Dev Space" id="nav-logo"></a>';
        } else {
            echo '<img src="img/logo.png" alt="Dev Space" id="nav-logo">';
        }
    ?>
    <ul id="menu">
        <?php
            include_once ("User.php");
            if(isset($_SESSION['email'])) {
                
                if($_SESSION["breadcrumb"] == "index.php"){
                    echo "<li id='current-menu-entry'>Home</li>
                    ";
                }else{
                    echo "<li><a href='index.php'>Home</a></li>
                    ";
                }
                if($_SESSION["breadcrumb"] == "profile.php"){
                    echo "<li id='current-menu-entry'>Profile</li>
                    ";
                }else{
                    
                    echo "<li><a href='profile.php'>Profile</a></li>
                    ";
                }
                
                if(User::isAdmin($_SESSION['email'])) {
                    if($_SESSION["breadcrumb"] == "adminTools.php"){
                        echo "<li id='current-menu-entry'>Admin tools</li>
                        ";
                    } else {
                        echo "<li><a href='adminTools.php'>Admin tools</a></li>
                        ";
                    }
                }
                echo "<li><a href='logout.php'>Logout</a></li>
                ";
            } else {
                if($_SESSION["breadcrumb"] == "index.php"){
                    echo "<li id='current-menu-entry'>Home</li>
                    ";
                }else{
                    echo "<li><a href='index.php'>Home</a></li>
                    ";
                }
                if($_SESSION["breadcrumb"] == "registrazione.php"){
                    echo "<li id='current-menu-entry'>Create a new account</li>
                    ";
                }else{
                    echo "<li><a href='registrazione.php'>Create a new account</a></li>
                    ";
                }
                if($_SESSION["breadcrumb"] == "login.php"){
                    echo "<li id='current-menu-entry'>Login</li>
                    ";
                }else{
                    echo "<li><a href='login.php'>Login</a></li>
                    ";
                }
            }
            if($_SESSION["breadcrumb"] == "about.php"){
                echo "<li id='current-menu-entry'>About</li>
                ";
            }else{
                echo "<li><a href='about.php'>About</a></li>
                ";
            }
        ?>
        
    </ul>
    <img src="img/hamburger.svg" alt="menu-icon" id="nav-menu-icon"/>
</div>