<?php
    include_once ("Connection.php");
    class Card {

        static function printCard ($topicName){
            $connection = new Connection();
            //Prendo nome e id del topic
            $connection -> prepareQuery("SELECT * FROM TOPICS WHERE Name='".$topicName."'");
            $topicsInfo = $connection->executeQuery();
            //Prendo Titolo dei primi 3 argomenti
            $connection -> prepareQuery("SELECT Title, Id FROM SUBTOPICS WHERE ".$topicsInfo[0]['Id']." = SUBTOPICS.TopicId LIMIT 3");
            $argumentsTitle = $connection -> executeQuery();
            //Print the test results
            echo "<div class='home-card'>";
            echo "<div class='thumbnail'>";
            $linkToImage =  str_replace(" ","%20",$topicsInfo[0]['ImageLink']);
            echo '<a href="ArticleLinks.php?id='.$topicsInfo[0]['Id'].'"><img src="'.$linkToImage.'" alt="Image for topic '.$topicName.'"/></a>';
            echo "</div>
                <div class='home-card-content'>
                    <h2><a href='ArticleLinks.php?id=".$topicsInfo[0]['Id']."'>".$topicsInfo[0]["Name"]."</a></h2>";
                    if(count($argumentsTitle) == 0){
                        echo '<p>There are no articles for this topic...</p>';
                    }else{
                        echo "<ul class='links'>";
                        foreach ($argumentsTitle as $item) {
                            echo "<li><a href='ArticleLinks.php?id=".$topicsInfo[0]['Id'].'#subtopic_'.$item['Id']."'>".$item["Title"]."</a></li>";
                        }
                        echo '</ul>';
                    }
            echo "</div>
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
            $numberOfRows4Cards = intval($topicsCount / 4); //quante righe piene devo predisporre
            $numberOfCardsLastRow = $topicsCount % 4;
            $numberOfTopicsPrinted = 0; //quanti argomenti devo stampare per ogni riga (massimo)
            if($topicsCount < 4) {
                $numberOfTopicsPrinted = $topicsCount;
            } else {
                $numberOfTopicsPrinted = 4;
            }

            $index = 0;
            while($numberOfRows4Cards > 0) {
                $counter = 0;
                echo "<div class='row'>";
                while($counter < $numberOfTopicsPrinted) {
                    Card::printCard($allTopics[$index]["Name"]);
                    $index += 1;
                    $counter +=1;
                }
                echo "</div>";
                $numberOfRows4Cards -= 1;
            }

            if($numberOfCardsLastRow>0){ //Se non ce ne sono inutile stampare una riga vuota
                $numberOfTopicsPrinted += $numberOfCardsLastRow;
                echo "<div class='row'>";
                $counter = 0;
                while($counter < $numberOfTopicsPrinted && $index<$topicsCount) {
                    Card::printCard($allTopics[$index]["Name"]);
                    $index += 1;
                    $counter +=1;
                }
                echo "</div>";
            }
            
            $connection = NULL;
        }

        //---------------------------------------------
        //Pagina gestione degli argomenti
        //---------------------------------------------

        static function deleteTopic($topicID){
            $connection = new Connection();
            $connection -> prepareQuery(
                "DELETE FROM TOPICS WHERE Id = $topicID");
            $result = $connection -> executeQueryDML();
            $connection = NULL;
        }

        static function insertTopic($title, $description, $image){
            if(!isset($title) || strlen($title)<2){
                return new ResultManager("<li>The topic title is not valid! (Probably is too short or empty)</li>", true);
            }
            if(!isset($description) || strlen($description)<2){
                return new ResultManager("<li>The topic description is not valid! (Probably is too short or empty)</li>", true);
            }
            $connection = new Connection();
            $connection -> prepareQuery(
                "INSERT INTO TOPICS (Name, Description, ImageLink)
                VALUES (:title, :desc, :imageLink)");
            $connection->bindParameterToQuery(":title", strip_tags($title), PDO::PARAM_STR);
            $connection->bindParameterToQuery(":desc", strip_tags($description), PDO::PARAM_STR);
            $connection->bindParameterToQuery(":imageLink", $image, PDO::PARAM_STR);
            $result = $connection -> executeQueryDML();
            $connection = NULL;
            return new ResultManager(NULL);
        }

        static function printInsertNewCardForm(){
            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" enctype="multipart/form-data" id="insert-new-card-form">
                <fieldset>
                    <h1>Create a new topic</h1>
                    <p>
                        <label for="title-input-box">Title of the new topic:</label>
                        <input type="text" name="titolo" id="title-input-box" placeholder="Write the topic title" required maxlength="100" />
                    </p>
                    <p>
                        <label for="descrizione">Description of the new topic:</label>
                        <textarea id="descrizione" rows="10" cols="40" name="descrizione" required placeholder="Write a description for the new topic"></textarea>
                    </p>
                    <p>
                        <label for="file-upload">Thumbnail image:</label>
                        <input id="file-upload" name="upfile" type="file" required />
                    </p>				
                    <p><input type="submit" name="add-topic" value="Create" /></p>
                </fieldset>
            </form>';
        }

        static function printDeleteTopicForm($topicID, $imageUrl){
            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                <input type="hidden" name="delete-topic" />
                <input type="hidden" name="image-url" value="'.$imageUrl.'" />
                <input type="hidden" name="topicID" value="'.$topicID.'" />
                <input type="image" title="Delete this topic" alt="button delete topic" src="https://frncscdf.github.io/Tecnologie-Web/img/waste-bin.svg" class="delete_button_gen" />
            </form>';
        }

        static function printAllCreatedCards(){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM TOPICS");
            $topics = $connection -> executeQuery();
            echo '<ul>';
            foreach ($topics as $topic) {
                echo '<li class="arg_title" id="topic_'.$topic['Id'].'">';
                echo '<div>';
                echo '<div class="details">
                    <h2><a href="ArticleLinks.php?id='.$topic['Id'].'">'.$topic['Name'].'</a></h2>
                    <h3>'.$topic['Description'].'</h3>
                </div>';
                echo '<div class="buttons">';
                Card::printDeleteTopicForm($topic['Id'], $topic['ImageLink']);
                echo '</div>'; //end buttons
                echo '</div>'; //end div for topic
                echo '</li>';
            }
            echo '</ul>';
            $connection = NULL;
        }

    }//class end

?>
