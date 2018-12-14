<?php
    include("../connection/Connection.php");
    class Card {

        static function printCard ($topicName){
            $connection = new Connection();
            $connection->prepareQuery("SELECT Name, Id FROM TOPICS WHERE Name='".$topicName."'");
            $topicsTitle = $connection->executeQuery();
            $connection->prepareQuery("SELECT Title FROM SUBTOPICS WHERE ". $topicsTitle[0]['Id']." = SUBTOPICS.TopicId");
            $argumentsTitle = $connection->executeQuery();
            //Print the test results
            echo "

            <div class='home-card'>
						<h2><a href='article.html'>".$result[0]['Name']."</a></h2>
						<a href='article.html'><img src='./img/algo.jpg' alt='algorithm topic' /></a>
                        <ul class='links'>";
                        foreach ($argumentsTitle as $item) {
                            "<li><a href='#'>".$item['Title']."</a></li>";
                        }
                        
						echo "<li><a href='article_links.html'>More &rarr;</a></li>
						</ul>
					</div>
            ";
            //Destroy the object
            $connection = NULL;
        }

        function printAllCards() {
            return 0;
        }
    }
    Card::printCard("Algoritmi");

?>