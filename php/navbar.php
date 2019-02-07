<div id="nav-full">
    <img src="img/logo.png" alt="Dev Space" id="nav-logo">
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
                    echo "<li id='current-menu-entry'>Il tuo profilo</li>
                    ";
                }else{
                    
                    echo "<li><a href='profile.php'>Il tuo profilo</a></li>
                    ";
                }
                
                if(User::isAdmin($_SESSION['email'])) {
                    if($_SESSION["breadcrumb"] == "adminTools.php"){
                        echo "<li id='current-menu-entry'>Strumenti</li>
                        ";
                    } else {
                        echo "<li><a href='adminTools.php'>Strumenti</a></li>
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
                    echo "<li id='current-menu-entry'>Registrazione</li>
                    ";
                }else{
                    echo "<li><a href='registrazione.php'>Registrazione</a></li>
                    ";
                }
                if($_SESSION["breadcrumb"] == "login.php"){
                    echo "<li id='current-menu-entry'>Accedi</li>
                    ";
                }else{
                    echo "<li><a href='login.php'>Accedi</a></li>
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