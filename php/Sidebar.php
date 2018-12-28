<?php
    include_once ("Connection.php");

    Class Sidebar{

        static function printSidebarIncludeHeader(){
            echo '<!-- Plugin CSS -->
            <link type="text/css" href="OverlayScrollbars/css/OverlayScrollbars.min.css" rel="stylesheet"/>
            <!-- Plugin JS -->
            <script src="OverlayScrollbars/js/OverlayScrollbars.min.js"></script>';
        }

        static function printSidebarEntry($topicID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            foreach ($subtopics as $subtopic) {
                echo '<li>
                    <a href="ArticleLinks.php?id='.$topicID.'#'.$subtopic['Id'].'">'.$subtopic['Title'].'</a>
                </li>
                ';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function printSidebar(){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM TOPICS");
            $topics = $connection -> executeQuery();
            echo '<ul id="sidebar">
            ';
            foreach ($topics as $topic) {
                echo '<li>
                <div>
                    <a href="ArticleLinks.php?id='.$topic['Id'].'">'.$topic['Name'].'</a>
                    <img src="https://frncscdf.github.io/Tecnologie-Web/img/expand-button.svg" class="expand-button" alt="Expand"/>
                </div>
                ';
                echo '<ul>
                ';
                Sidebar::printSidebarEntry($topic['Id']);
                echo '</ul>
                ';
                echo '</li>
                ';
            }
            echo '</ul>';
            //Destroy the object
            $connection = NULL;
        }

        static function printNavbar(){
            echo '<div id="nav" class="sidebar-nav">
				<img src="img/hamburger.svg" alt="hamburger-icon" id="nav-hamburger"/>
                <h1>Nome Sito</h1>
                <ul id="menu">';
            if(isset($_SESSION['email'])) {
                echo "<li><a href='index.php'>Home</a></li>"; 
                echo "<li><a href='profile.php'>Il tuo profilo</a></li>";
                echo "<li><a href='logout.php'>Logout</a></li>";
            }else{
                echo "<li><a href='index.php'>Home</a></li>";
				echo "<li><a href='registrazione.php'>Registrati</a></li>";
				echo "<li><a href='login.php'>Accedi</a></li>";
            }
            echo '<li><a href="">About</a></li>';
            echo '</ul>
            <img src="img/hamburger.svg" alt="menu-icon" id="nav-menu-icon"/>
			</div>';
        }
    }

?>
