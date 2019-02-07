<?php
    include_once ("Connection.php");
    include_once ("User.php");

    Class Sidebar{

        static function printSidebarIncludeHeader(){
            echo '<!-- Plugin CSS -->
            <link type="text/css" href="OverlayScrollbars/css/OverlayScrollbars.min.css" rel="stylesheet"/>
            <!-- Plugin JS -->
            <script src="OverlayScrollbars/js/OverlayScrollbars.min.js"></script>';
        }

        static function printSidebarEntry($topicID, $subtopicID = NULL, $isarticle = false){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            foreach ($subtopics as $subtopic) {
                if($isarticle && $subtopic['Id'] === $subtopicID){
                    echo '<li class="breadcrumb">';
                }else{
                    echo '<li>';
                }
                echo '<a href="ArticleLinks.php?id='.$topicID.'#subtopic_'.$subtopic['Id'].'">'.$subtopic['Title'].'</a>
                </li>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function checkSidebarHasEntries($topicID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            return count($subtopics) > 0;
        }

        static function getTopicInfoFromArticleID($articleID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT TOPICS.Id as TopicID, SUBTOPICS.Id as SubtopicID
            FROM ARTICLES, SUBTOPICS, TOPICS
            WHERE ARTICLES.Id = $articleID AND ARTICLES.SubtopicID = SUBTOPICS.Id AND SUBTOPICS.TopicID = TOPICS.Id");
            $topicID = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            return $topicID[0];
        }

        static function printArticleSidebar($articleID){
            $info = Sidebar::getTopicInfoFromArticleID($articleID);
            Sidebar::printSidebar($info['TopicID'], $info['SubtopicID'], true);
        }

        static function printSidebarSearchBox(){
            echo '<div id="sidebar-header">
				<form method="get" action="search.php">
					<fieldset id="search-bar">
                        <p>
                            <h1><label for="search-bar-textarea">Cerca articoli ed argomenti</label></h1>';
                            if(isset($_GET["search-term"])){
                                echo '<input type="text" id="search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$" required value="'.$_GET["search-term"].'">';
                            }else{
                                echo '<input type="text" id="search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$" required>';
                            }
                        echo '</p>
	                	<p><input type="submit" value="Cerca"></p>
					</fieldset>
				</form>
			</div>';
        }

        static function printSidebar($topicID, $subtopicID = NULL, $isarticle = false){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM TOPICS");
            $topics = $connection -> executeQuery();
            Sidebar::printSidebarSearchBox();
            echo '<ul id="sidebar">
            ';
            foreach ($topics as $topic) {
                if(Sidebar::checkSidebarHasEntries($topic['Id'])){
                    if($topic['Id'] === $topicID && !$isarticle){
                        echo '<li class="breadcrumb">';
                    }else{
                        echo '<li>';
                    }
                    echo '<div>
                        <a href="ArticleLinks.php?id='.$topic['Id'].'">'.$topic['Name'].'</a>
                        <img src="https://frncscdf.github.io/Tecnologie-Web/img/expand-button.svg" id="'.$topic['Id'].'" class="expand-button" alt="Expand"/>
                    </div>
                    ';
                    echo '<ul>
                    ';
                    Sidebar::printSidebarEntry($topic['Id'], $subtopicID, $isarticle);
                    echo '</ul>
                    ';
                    echo '</li>
                    ';
                }
            }
            echo '</ul>';
            //Destroy the object
            $connection = NULL;
        }

        static function printNavbar(){
            echo '<div id="nav" class="sidebar-nav">
                <img src="img/list.svg" alt="hamburger-icon" id="nav-hamburger"/>
                <img src="img/logo.png" alt="DevSpace-Logo" id="nav-logo"/>
                <ul id="menu">';
            if(isset($_SESSION['email'])) {
                echo "<li><a href='index.php'>Home</a></li>"; 
                echo "<li><a href='profile.php'>Il tuo profilo</a></li>";
                if(User::isAdmin($_SESSION['email'])) {
                    echo "<li><a href='adminTools.php'>Strumenti</a></li>
                    ";
                }
                echo "<li><a href='logout.php'>Logout</a></li>";
            }else{
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='registrazione.php'>Registrati</a></li>";
                echo "<li><a href='login.php'>Accedi</a></li>";
            }
            echo '<li><a href="about.php">About</a></li>';
            echo '</ul>
            <img src="img/hamburger.svg" alt="nav menu icon" id="nav-menu-icon"/>
            </div>';
        }

        static function openSidebarEntry($topicID){
            echo '<script>sidebarExtendTopic("'.$topicID.'")</script>';
        }

        static function openSidebarEntryArticle($articleID){
            $info = Sidebar::getTopicInfoFromArticleID($articleID);
            echo '<script>sidebarExtendTopic("'.$info['TopicID'].'")</script>';
        }

    }//end class

?>
