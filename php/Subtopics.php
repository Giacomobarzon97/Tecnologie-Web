<?php
    include_once ("Connection.php");
    include_once ("User.php");
    include_once ("ResultManager.php");
    include_once ('SearchManager.php');
    include_once ('validateData.php');
    
    class Subtopics {

        static function checkIfTopicExists($topicID){
            if(!isset($topicID)){
                return false;
            }
            if(!is_numeric($topicID)){
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM TOPICS WHERE ".$topicID." = Id");
            $result = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            if(isset($result[0])) {
                return true;
            }else{
                return false;
            }
        }

        static function checkIfSubtopicExists($subtopicID){
            if(!isset($subtopicID)){
                return false;
            }
            if(!is_numeric($subtopicID)){
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$subtopicID." = Id");
            $result = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            if(isset($result[0])) {
                return true;
            }else{
                return false;
            }
        }

        static function getTopicIDFromSubtopic($subtopicID){
            if(!isset($subtopicID)){
                return false;
            }
            if(!is_numeric($subtopicID)){
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery("SELECT TOPICS.Id
                FROM SUBTOPICS, TOPICS
                WHERE SUBTOPICS.TopicID = TOPICS.Id AND SUBTOPICS.Id=".$subtopicID);
            $result = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            if(isset($result[0])) {
                return $result[0]['Id'];
            }else{
                return false;
            }
        }

        static function getSubtopicTitle($subtopicID){
            if(!isset($subtopicID)){
                return false;
            }
            if(!is_numeric($subtopicID)){
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery("SELECT Title FROM SUBTOPICS WHERE ".$subtopicID." = Id");
            $result = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            if(isset($result[0])) {
                return $result[0]['Title'];
            }else{
                return false;
            }
        }

        static function getTopicTitle($topicID){
            if(!isset($topicID)){
                return false;
            }
            if(!is_numeric($topicID)){
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery("SELECT Name FROM TOPICS WHERE ".$topicID." = Id");
            $result = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            if(isset($result[0])) {
                return $result[0]['Name'];
            }else{
                return false;
            }
        }

        static function printArticlesList($subtopic, $topicID, $loggedUserIsAdmin){
            $connection = new Connection();
            //Prendo Tutti gli articoli
            $connection -> prepareQuery("SELECT * FROM ARTICLES WHERE ".$subtopic['Id']." = SubtopicID");
            $articles = $connection -> executeQuery();
            //Print the test results
            foreach ($articles as $article) {
                echo '<li>';
                echo '<a href="ReadArticle.php?id='.$article['Id'].'">'.$article['Title'].'</a>';
                if($loggedUserIsAdmin){
                    echo '<div>
                    <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                        <input type="hidden" name="delete-article" />
                        <input type="hidden" name="articleID" value="'.$article['Id'].'" />
                        <input type="image" title="Delete this article" alt="button delete article '.$article['Title'].'" src="./img/waste-bin.svg" class="delete_button_link" />
                    </form>
                    <form action="writeArticle.php" method="GET">
                        <input type="hidden" name="subtopicID" value="'.$subtopic['Id'].'" />
                        <input type="hidden" name="topicID" value="'.$topicID.'" />
                        <input type="hidden" name="articleID" value="'.$article['Id'].'" />
                        <input type="image" title="Edit this article" alt="button edit article '.$article['Title'].'" src="./img/edit.svg" class="add_button_link" />
                    </form>
                    </div>';
                }
                echo '</li>';
            }
            //Non ci sono articoli
            if(count($articles)==0){
                echo '<li>';
                echo '<p>There are no articles in this category...</p>';
                echo '</li>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function printSubtopicsList($topicID, $loggedUserEmail){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            $userisAdmin = User::isAdmin($loggedUserEmail);
            if(count($subtopics) == 0){
                echo '<li class="arg_title">';
                echo '<div>'; //--Apertura div titolo--
                //Stampa dettagli elemento
                echo '<div class="details">';
                echo '<h2 class="subtopic-title" >There are no subtopics for this topic ...</h2>';
                echo '</div>';
                echo '</div>'; //--Chiusura div titolo--
                echo '</li>';
            }
            foreach ($subtopics as $subtopic) {
                //Stampa div pre-argomenti
                echo '<li class="arg_title">';
                echo '<div>'; //--Apertura div titolo--
                //Stampa dettagli elemento
                echo '<div class="details">';
                echo '<h2 class="subtopic-title" ><span id="subtopic_'.$subtopic['Id'].'"></span>'.$subtopic['Title'].'</h2>';
                if(strlen($subtopic['Description']) > 0){
                    echo '<h3>'.$subtopic['Description'].'</h3>';
                }
                echo '</div>';
                //Stampa bottoni elemento (se l'utente è admin)
                if($userisAdmin){
                    echo '<div class="buttons">';
                    echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                            <input type="hidden" name="delete-subtopic" />
                            <input type="hidden" name="subtopicID" value="'.$subtopic['Id'].'" />
                            <input type="image" title="Delete this subtopic" alt="button delete subtopic '.$subtopic['Title'].'" src="./img/waste-bin.svg" class="delete_button_gen" />
                        </form>
                        <form action="writeArticle.php" method="GET">
                            <input type="hidden" name="subtopicID" value="'.$subtopic['Id'].'" />
                            <input type="hidden" name="topicID" value="'.$topicID.'" />
                            <input type="image" title="Write an article for this subtopic" alt="button write article in subtopic '.$subtopic['Title'].'" src="./img/new-article.svg" class="add_button_gen" />
                        </form>';
                    echo '</div>';
                }
                echo '</div>'; //--Chiusura div titolo--
                //Stampa link sotto-argomento
                echo '<ul class="arg_link">';
                Subtopics::printArticlesList($subtopic, $topicID, $userisAdmin);
                echo '</ul>';
                echo '</li>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function printTopicIntroduction($topicID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM TOPICS WHERE ".$topicID." = Id");
            $topic = $connection -> executeQuery();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            //Stampa parte iniziale
            echo '<h1>'.$topic[0]['Name'].'</h1>
            <p>'.$topic[0]['Description'].'</p>';
            if(count($subtopics) > 0){
                echo '<h2>What you will learn:</h2>
                <ul>';
                //Stampa cosa imparerai
                foreach ($subtopics as $subtopic) {
                    echo '<li><a href="#subtopic_'.$subtopic['Id'].'">'.$subtopic['Title'].'</a></li>';
                }
                echo '</ul>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function printInsertSubtopicForm($sessionEmail, $topicID){
            if(User::isAdmin($sessionEmail)){
                echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" id="insert-new-subtopic-form">
                    <fieldset>
                        <p>Create a new sub-topic</p>
                        <input type="hidden" name="topicID" value="'.$topicID.'" />
                            <p>
                                <label for="new-subtopic-title">Title of the new sub-topic:</label>
                                <input type="text" name="title" id="new-subtopic-title" pattern="^[a-zA-Z0-9_!.\'()-]+( [a-zA-Z0-9_!.\'()-]+)*$" placeholder="Subtopic title" required maxlength="100" />
                            </p>
                            <p>
                                <label for="descrizione">Description of the new sub-topic:</label>
                                <textarea id="descrizione" rows="10" cols="40" required name="descrizione" placeholder="Write a description for the new sub-topic (max 500 characters)"></textarea>
                            </p>
                            <p><input type="submit" name="add-subtopic" value="Create" /></p>
                    </fieldset>
                </form>';
            }
        }

        static function insertSubtopic($title, $description, $topicID){
            if(!isset($title) || strlen($title)<2 || strlen($title)>100 || !ValidateData::checkStringIsEmpty($title)){
                return new ResultManager("<li>The subtopic title is not valid! (Probably is too short/long or empty)</li>", true);
            }
            if(!isset($description) || strlen($description)<2 || strlen($description)>500 || !ValidateData::checkStringIsEmpty($description)){
                return new ResultManager("<li>The subtopic description is not valid! (Probably is too short/long or empty)</li>", true);
            }
            if(!Subtopics::checkIfTopicExists($topicID)){
                return new ResultManager("<li>The received TOPICID is not valid!</li>", true);
            }
            $connection = new Connection();
            $connection -> prepareQuery(
                "INSERT INTO SUBTOPICS (Title, Description, TopicID)
                VALUES (:title, :desc, :topicid)");
            $connection->bindParameterToQuery(":title", strip_tags($title), PDO::PARAM_STR);
            $connection->bindParameterToQuery(":desc", strip_tags($description), PDO::PARAM_STR);
            $connection->bindParameterToQuery(":topicid", $topicID, PDO::PARAM_STR);
            $result = $connection -> executeQueryDML();
            $connection = NULL;
            return new ResultManager(NULL);
        }

        static function deleteSubtopic($subtopicID){
            $connection = new Connection();
            $connection -> prepareQuery(
                "DELETE FROM SUBTOPICS WHERE Id = $subtopicID");
            $result = $connection -> executeQueryDML();
        }
    }

?>
