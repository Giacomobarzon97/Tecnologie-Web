<?php
include_once("Connection.php");
include_once("User.php");

Class Sidebar
{

    static function printSidebarIncludeHeader()
    {
        echo '<!-- Plugin CSS -->
            <link type="text/css" href="OverlayScrollbars/css/OverlayScrollbars.min.css" rel="stylesheet"/>
            <!-- Plugin JS -->
            <script src="OverlayScrollbars/js/OverlayScrollbars.min.js"></script>';
    }

    static function printSidebarEntry($topicID, $subtopicID = NULL, $isarticle = false)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT * FROM SUBTOPICS WHERE " . $topicID . " = TopicID");
        $subtopics = $connection->executeQuery();
        foreach ($subtopics as $subtopic) {
            if ($isarticle && $subtopic['Id'] === $subtopicID) {
                echo '<li class="breadcrumb">';
            } else {
                echo '<li>';
            }
            echo '<a href="ArticleLinks.php?id=' . $topicID . '#subtopic_' . $subtopic['Id'] . '">' . $subtopic['Title'] . '</a>
                </li>';
        }
        //Destroy the object
        $connection = NULL;
    }

    static function checkSidebarHasEntries($topicID)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT * FROM SUBTOPICS WHERE " . $topicID . " = TopicID");
        $subtopics = $connection->executeQuery();
        //Destroy the object
        $connection = NULL;
        return count($subtopics) > 0;
    }

    static function getTopicInfoFromArticleID($articleID)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT TOPICS.Id as TopicID, SUBTOPICS.Id as SubtopicID
            FROM ARTICLES, SUBTOPICS, TOPICS
            WHERE ARTICLES.Id = $articleID AND ARTICLES.SubtopicID = SUBTOPICS.Id AND SUBTOPICS.TopicID = TOPICS.Id");
        $topicID = $connection->executeQuery();
        //Destroy the object
        $connection = NULL;
        return $topicID[0];
    }

    static function printArticleSidebar($articleID, $isNoJsSidebar = false)
    {
        $info = Sidebar::getTopicInfoFromArticleID($articleID);
        Sidebar::printSidebar($info['TopicID'], $info['SubtopicID'], true, $isNoJsSidebar);
    }

    static function printSidebarSearchBox()
    {
        echo '<div class="sidebar-header">
                <img src="img/close.svg" alt="close sidebar button" id="close-sidebar-button" />
				<form method="get" action="search.php">
					<fieldset class="search-bar">
                        <p>
                            <label for="search-bar-textarea">Search for topics and articles</label>';
        if (isset($_GET["search-term"])) {
            echo '<input type="text" id="search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" required value="' . $_GET["search-term"] . '" />';
        } else {
            echo '<input type="text" id="search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" required />';
        }
        echo '</p>
	                	<p><input type="submit" value="Search"></p>
					</fieldset>
				</form>
			</div>';
    }

    static function printSidebar($topicID, $subtopicID = NULL, $isarticle = false, $isNoJsSidebar = false)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT * FROM TOPICS");
        $topics = $connection->executeQuery();
        if (!$isNoJsSidebar) {
            Sidebar::printSidebarSearchBox();
        }
        echo '<ul class="sidebar">
            ';
        foreach ($topics as $topic) {
            $hasEntries = Sidebar::checkSidebarHasEntries($topic['Id']);
            if ($topic['Id'] === $topicID && !$isarticle) {
                echo '<li class="breadcrumb">';
            } else {
                echo '<li>';
            }
            echo '<div>';
            if ($topic['Id'] === $topicID && !$isarticle) { //Se ci sono dentro il titolo non lo metto come link
                echo '<p>' . $topic['Name'] . '</p>';
            } else {
                echo '<a href="ArticleLinks.php?id=' . $topic['Id'] . '">' . $topic['Name'] . '</a>';
            }
            if (!$isNoJsSidebar && $hasEntries) { //Se il topic ha almeno un elemento ci metto la freccetta
                echo '<img src="./img/expand-button.svg" id="' . $topic['Id'] . '" class="expand-button" alt="Expand"/>';
            }
            echo '</div>
                ';
            if ($hasEntries) { //Controllo se il topic ha argomenti prima di stampare l'elenco
                echo '<ul>
                    ';
                Sidebar::printSidebarEntry($topic['Id'], $subtopicID, $isarticle);
                echo '</ul>
                    ';
            }
            echo '</li>
                ';
        }
        echo '</ul>';
        //Destroy the object
        $connection = NULL;
    }

    static function printNavbar()
    {
        echo '<div id="nav" class="sidebar-nav">
                <noscript>
				    <a href="#nojs-sidebar-wrapper"><img src="img/list.svg" alt="hamburger icon" id="nojs-hamburger"/></a>
				</noscript>
                <img src="img/list.svg" alt="hamburger-icon" id="nav-hamburger"/>
                <a href="index.php"><img src="img/logo.png" alt="Dev Space" id="nav-logo"></a>
                <ul id="menu">';
        if (isset($_SESSION['email'])) {
            echo "<li><a href='index.php' accesskey='h'>Home</a></li>";
            echo "<li><a href='profile.php' accesskey='p'>Profile</a></li>";
            if (User::isAdmin($_SESSION['email'])) {
                echo "<li><a href='adminTools.php' accesskey='t'>Admin tools</a></li>
                    ";
            }
            echo "<li><a href='logout.php' accesskey='l'>Logout</a></li>";
        } else {
            echo "<li><a href='index.php' accesskey='h'>Home</a></li>";
            echo "<li><a href='registrazione.php' accesskey='c'>Create a new account</a></li>";
            echo "<li><a href='login.php' accesskey='l'>Login</a></li>";
        }
        echo '<li><a href="about.php" accesskey="a">About</a></li>';
        echo '</ul>
            <noscript>
			<a href="#nojs-menu"><img src="img/hamburger.svg" alt="nav menu icon" id="nojs-menu-icon"/></a>
			</noscript>
            <img src="img/hamburger.svg" alt="nav menu icon" id="nav-menu-icon"/>
            </div>';
    }

    static function openSidebarEntry($topicID)
    {
        echo '<script>sidebarExtendTopic("' . $topicID . '")</script>';
    }

    static function openSidebarEntryArticle($articleID)
    {
        $info = Sidebar::getTopicInfoFromArticleID($articleID);
        echo '<script>sidebarExtendTopic("' . $info['TopicID'] . '")</script>';
    }

    static function printNoJsNavbar()
    {
        echo '<ul id="nojs-menu">';
        echo '<li><h1>Menu</h1></li>';
        if (isset($_SESSION['email'])) {
            echo "<li><a href='index.php' accesskey='h'>Home</a></li>";
            echo "<li><a href='profile.php' accesskey='p'>Profile</a></li>";
            if (User::isAdmin($_SESSION['email'])) {
                echo "<li><a href='adminTools.php' accesskey='t'>Admin tools</a></li>
                    ";
            }
            echo "<li><a href='logout.php' accesskey='l'>Logout</a></li>";
        } else {
            echo "<li><a href='index.php' accesskey='h'>Home</a></li>";
            echo "<li><a href='registrazione.php' accesskey='c'>Create a new account</a></li>";
            echo "<li><a href='login.php' accesskey='l'>Login</a></li>";
        }
        echo '<li><a href="about.php" accesskey="a">About</a></li>';
        echo '</ul>';
    }

    static function printNoJsSidebarSearchbox()
    {
        echo '<div class="sidebar-header">
					<form method="get" action="search.php">
                        <fieldset class="search-bar">
                            <p>
                                <label for="nojs-search-bar-textarea">Search for topics and articles</label>';
        if (isset($_GET["search-term"])) {
            echo '<input type="text" accesskey="s" id="nojs-search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" required value="' . $_GET["search-term"] . '" />';
        } else {
            echo '<input type="text" accesskey="s" id="nojs-search-bar-textarea" name="search-term" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" required />';
        }
        echo '</p>
                            <p><input type="submit" value="Search"></p>
                        </fieldset>
				    </form>
				</div>';
    }

}//end class

?>
