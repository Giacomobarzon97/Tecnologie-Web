<div id="nav-full">
            <img src="img/logo.png" alt="Dev Space" id="nav-logo">
            <ul id="menu">
                <?php
                    if(isset($_SESSION['email'])) {
                        if($_SESSION["lastVisitedPage"] == "index.php"){
                            echo "<li id='current-menu-entry'>Home</li>
                            ";
                        }else{
                            echo "<li><a href='index.php'>Home</a></li>
                            ";
                        }
                        echo "<li><a href='profile.php'>Il tuo profilo</a></li>
                        ";
                        echo "<li><a href='logout.php'>Logout</a></li>
                        ";
                    } else {
                        if($_SESSION["lastVisitedPage"] == "index.php"){
                            echo "<li id='current-menu-entry'>Home</li>
                            ";
                        }else{
                            echo "<li><a href='index.php'>Home</a></li>
                            ";
                        }
                        echo "<li><a href='registrazione.php'>Registrati</a></li>
                        ";
                        echo "<li><a href='login.php'>Accedi</a></li>
                        ";
                    }
                    if($_SESSION["lastVisitedPage"] == "about.php"){
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
