<?php
    include_once ("Connection.php");
    class Card {

        static function printCard ($topicName){
            $connection = new Connection();
            //Prendo nome e id del topic
            $connection -> prepareQuery("SELECT * FROM TOPICS WHERE Name='".$topicName."'");
            $topicsInfo = $connection->executeQuery();
            //Prendo Titolo degli argomenti
            $connection -> prepareQuery("SELECT Title FROM SUBTOPICS WHERE ".$topicsInfo[0]['Id']." = SUBTOPICS.TopicId");
            $argumentsTitle = $connection -> executeQuery();
            //Print the test results
            echo 
            "<div class='home-card'>
				<h2><a href='ArticleLinks.php?id=".$topicsInfo[0]['Id']."'>".$topicsInfo[0]["Name"]."</a></h2>
				<a href='ArticleLinks.php?id=".$topicsInfo[0]['Id']."'>"."<img src='https://frncscdf.github.io/Tecnologie-Web/img/algo.jpg' alt='algorithm topic' /></a>
                <ul class='links'>";
                foreach ($argumentsTitle as $item) {
                    echo "<li><a href='ArticleLinks.php?id=".$topicsInfo[0]['Id']."'>".$item["Title"]."</a></li>";
                }
                echo "</ul>
                <a href='ArticleLinks.php?id=".$topicsInfo[0]['Id']."' class='home-card-more-link'>More &rarr;</a>
            </div>";
                    
            //Destroy the object
            $connection = NULL;
        }

        static function printAllCards() {
            $connection = new Connection();
            $connection -> prepareQuery("SELECT COUNT(*) as c FROM TOPICS");
            $numberOfTopics = $connection -> executeQuery();
            $connection -> prepareQuery("SELECT Name, Id FROM TOPICS");
            $allTopics = $connection -> executeQuery();

            $topicsCount = $numberOfTopics[0]["c"]; //quanti sono i topic totali
            $numberOfRows4Cards = $topicCount / 4; //quante righe piene devo predisporre
            $numberOfCardsLastRow = $topicCount % 4;
            $numberOfTopicsPrinted = 0; //quanti argomenti devo stampare per ogni riga (massimo)
            if($topicsCounts < 4) {
                $numberOfTopicsPrinted = $topicsCount;
            } else {
                $numberOfTopicsPrinted = 4;
            }
            $index = 0;
            while($numberOfRows4Cards > 0) {
                echo "<div class='row'>";
                while($index < $numberOfTopicsPrinted) {
                    Card::printCard($allTopics[$index]["Name"]);
                    $index += 1;
                }
                echo "</div>";
                $numberOfRows -= 1;
            }

            $numberOfTopicsPrinted += $numberOfCardsLastRow;
            echo "<div class='row'>";
            while($index < $numberOfTopicsPrinted) {
                Card::printCard($allTopics[$index]["Name"]);
                $index += 1;
            }
            echo "</div>";
            
            $connection = NULL;
        }
    }

?>