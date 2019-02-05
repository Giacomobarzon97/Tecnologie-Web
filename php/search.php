<?php

    if(!isset($_GET["search-term"])){
        header("Location: errore.php?errorCode=404");
    }

    include_once('sessionManager.php');
    include_once('Sidebar.php');
    include_once('SearchManager.php');

?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Risultati di ricerca per "<?php echo $_GET["search-term"] ?>" &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Pagina risultati di ricerca" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
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
									<h2>Risultati Card(argomenti)</h2>
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
                                        echo '<li>Non ci sono risultati in questa sezione...</li>';
                                    }
                                    unset($results);
                                ?>
                            </ul>
                        </li>
                        <li class="arg_title">
							<div>
								<div class="details">
									<h2>Risultati Subtopic(sotto-argomenti)</h2>
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
                                        echo '<li>Non ci sono risultati in questa sezione...</li>';
                                    }
                                    unset($results);
                                ?>
							</ul>
                        </li>
                        <li class="arg_title">
							<div>
								<div class="details">
									<h2>Risultati Article(articoli)</h2>
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
                                        echo '<li>Non ci sono risultati in questa sezione...</li>';
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
            ?>
        </div>
    </body>
</html>