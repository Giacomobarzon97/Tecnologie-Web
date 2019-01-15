<?php
    include_once ("Connection.php");
    include_once ("User.php");
    
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

        static function printArticlesList($subtopicID, $loggedUserIsAdmin){
            $connection = new Connection();
            //Prendo Tutti gli articoli
            $connection -> prepareQuery("SELECT * FROM ARTICLES WHERE ".$subtopicID." = SubtopicID");
            $articles = $connection -> executeQuery();
            //Print the test results
            foreach ($articles as $article) {
                echo '<li>';
                echo '<a href="ReadArticle.php?id='.$article['Id'].'">'.$article['Title'].'</a>';
                if($loggedUserIsAdmin){
                    echo '<div>
                    <form action='.$_SERVER['REQUEST_URI'].' method="POST">
                        <input type="hidden" name="delete-article" />
                        <input type="hidden" name="articleID" value="'.$article['Id'].'" />
                        <input type="image" alt="cestino elimina link" src="https://frncscdf.github.io/Tecnologie-Web/img/waste-bin.svg" class="delete_button_link" />
                    </form>
                    </div>';
                }
				echo '</li>';
            }
            //Non ci sono articoli
            if(count($articles)==0){
                echo '<li>';
                echo '<p>Non ci sono ancora articoli in questa categoria...</p>';
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
                echo '<h2 class="subtopic-title" >Non ci sono ancora sottoargomenti per questo argomento...</h2>';
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
                echo '<h2 class="subtopic-title" ><span id="'.$subtopic['Id'].'"></span>'.$subtopic['Title'].'</h2>';
                echo '<h3>'.$subtopic['Description'].'</h3>';
                echo '</div>';
                //Stampa bottoni elemento (se l'utente è admin)
                if($userisAdmin){
                    echo '<div class="buttons">';
                    echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                            <input type="hidden" name="delete-subtopic" />
                            <input type="hidden" name="subtopicID" value="'.$subtopic['Id'].'" />
                            <input type="image" alt="cestino elimina sotto-argomento" src="https://frncscdf.github.io/Tecnologie-Web/img/waste-bin.svg" class="delete_button_gen" />
                        </form>
                        <form action="writeArticle.php" method="GET">
                            <input type="hidden" name="subtopicID" value="'.$subtopic['Id'].'" />
                            <input type="hidden" name="topicID" value="'.$topicID.'" />
                            <input type="image" alt="aggiunta sotto-argomento" src="https://frncscdf.github.io/Tecnologie-Web/img/new-article.svg" class="add_button_gen" />
                        </form>';
                    echo '</div>';
                }
                echo '</div>'; //--Chiusura div titolo--
                //Stampa link sotto-argomento
                echo '<ul class="arg_link">';
                Subtopics::printArticlesList($subtopic['Id'], $userisAdmin);
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
            <p>'.$topic[0]['Description'].'</p>
            <h2>Cosa imparerai:</h2>
            <ul>';
            //Stampa cosa imparerai
            foreach ($subtopics as $subtopic) {
                echo '<li><a href="#'.$subtopic['Id'].'">'.$subtopic['Title'].'</a></li>';
            }
            //Stampa form di aggiunta
            echo '</ul>';
            //Destroy the object
            $connection = NULL;
        }

        static function printInsertSubtopicForm($sessionEmail, $topicID){
            if(User::isAdmin($sessionEmail)){
                echo '<div id="subtopics-error-box-insert-subtopic"></div>
                <form action="'.$_SERVER['REQUEST_URI'].'" method="POST" id="insert-new-subtopic-form">
                    <fieldset>
                        <p>Inserisci un nuovo sotto-argomento</p>
                        <input type="hidden" name="topicID" value="'.$topicID.'" />
                            <p>
                                <label for="title">Titolo del nuovo subtopic:</label>
                                <input type="text" name="title" id="new-subtopic-title" placeholder="Titolo del subtopic" required maxlength="100" />
                            </p>
                            <p>
                                <label for="description">Descrizione del nuovo subtopic:</label>
                                <input type="text" name="description" id="new-subtopic-description" placeholder="Descrizione del subtopic" required maxlength="10000" />
                            </p>
                            <p><input type="submit" name="add-subtopic" value="Invia" /></p>
                    </fieldset>
                </form>';
            }else{ //TOREMOVE
                echo '(Non puoi inserire un nuovo sotto-argomento, effettua il login come amministratore)';
            }
        }

        static function insertSubtopic($title, $description, $topicID){
            $connection = new Connection();
            $connection -> prepareQuery(
                "INSERT INTO SUBTOPICS (Title, Description, TopicID)
                VALUES (:title, :desc, :topicid)");
            $connection->bindParameterToQuery(":title", $title, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":desc", $description, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":topicid", $topicID, PDO::PARAM_STR);
            $result = $connection -> executeQueryDML();
            $connection = NULL;
        }

        static function deleteSubtopic($subtopicID){
            $connection = new Connection();
            $connection -> prepareQuery(
                "DELETE FROM SUBTOPICS WHERE Id = $subtopicID");
            $result = $connection -> executeQueryDML();
        }
    }

?>
