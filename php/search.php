<?php

    if(!isset($_GET["search-term"])){
        header("Location: errore.php?errorCode=404");
    }

    include_once('sessionManager.php');
    include_once('Sidebar.php');
    include_once('SearchManager.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Search results for "<?php echo $_GET["search-term"] ?>" &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina risultati di ricerca" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>		
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        <?php
            Sidebar::printSidebarIncludeHeader();
        ?>
    </head>
    <body>
        <button onclick="topFunction()" id="retTop" title="Torna su"></button>
        <div id="mobile-sidebar-mask">
        </div>
        <div id="sidebar-wrapper">
        <?php
            Sidebar::printSidebar(-1);
        ?>
        </div>
        <div id="rightSideWrapper">
            <?php
                Sidebar::printNavbar();
            ?>
            <div id="main">
                <div id="content-article-body">
					<h1>Research results</h1>
					<ul>
						<li class="arg_title">
							<div>
								<div class="details">
									<h2>Topics found</h2>
								</div>
                            </div>
                            <ul class="arg_link">
                                <?php
                                    $results = SearchManager::getTopicsResults($_GET["search-term"]);
                                    if(count($results)>0){
                                        foreach ($results as $card) {
                                            echo '<li>';
                                            echo '<h2><a href="'.$card->getLink().'">'.$card->getName().'</a></h2>';
                                            if($card->getDescription() != NULL){
                                                echo '<h3>'.$card->getDescription().'</h3>';
                                            }
                                            echo '</li>';
                                        }
                                    }else{
                                        echo '<li>There are no results in this section ...</li>';
                                    }
                                    unset($results);
                                ?>
                            </ul>
                        </li>
                        <li class="arg_title">
							<div>
								<div class="details">
									<h2>Subtopics found</h2>
								</div>
							</div>
							<ul class="arg_link">
                                <?php
                                    $results = SearchManager::getSubTopicsResults($_GET["search-term"]);
                                    if(count($results)>0){
                                        foreach ($results as $subtopic) {
                                            echo '<li>';
                                            echo '<h2><a href="'.$subtopic->getLink().'">'.$subtopic->getName().'</a></h2>';
                                            if($subtopic->getDescription() != NULL){
                                                echo '<h3>'.$subtopic->getDescription().'</h3>';
                                            }
                                            echo '</li>';
                                        }
                                    }else{
                                        echo '<li>There are no results in this section ...</li>';
                                    }
                                    unset($results);
                                ?>
							</ul>
                        </li>
                        <li class="arg_title">
							<div>
								<div class="details">
									<h2>Articles found</h2>
								</div>
							</div>
							<ul class="arg_link">
                                <?php
                                    $results = SearchManager::getArticlesResults($_GET["search-term"]);
                                    if(count($results)>0){
                                        foreach ($results as $article) {
                                            echo '<li>';
                                            echo '<h2><a href="'.$article->getLink().'">'.$article->getName().'</a></h2>';
                                            echo '</li>';
                                        }
                                    }else{
                                        echo '<li>There are no results in this section ...</li>';
                                    }
                                    unset($results);
                                ?>
							</ul>
						</li>
					</ul>
				</div>
            </div> <!--Chiusura div main-->
            <?php
                include_once ('footer.php');
                Footer::printDefaultFooterWithJSError();
            ?>
        </div>
    </body>
</html>