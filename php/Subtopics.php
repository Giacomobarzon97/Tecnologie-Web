<?php
    include_once ("Connection.php");
    include_once ("User.php");
    class Subtopics {

        static function printArticlesList($subtopicID){
            $connection = new Connection();
            //Prendo Tutti gli articoli
            $connection -> prepareQuery("SELECT * FROM ARTICLES WHERE ".$subtopicID." = SubtopicID");
            $articles = $connection -> executeQuery();
            //Print the test results
            foreach ($articles as $article) {
                echo '<li> 
				    <a href="'.$article['Id'].'">'.$article['Title'].'</a>
				</li>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function checkIfTopicExists($topicID){
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

        static function printSubtopicsList($topicID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            foreach ($subtopics as $subtopic) {
                //Stampa div pre-argomenti
                echo '<li class="arg_title" id="LAR">
                        <div>';
                echo '<h2>'.$subtopic['Title'].'</h2>';
                echo '<h3>'.$subtopic['Description'].'</h3>';
                echo '<button class="add_button"></button>
                    <button class="delete_button"></button>';
                echo '</div>';
                echo '<ul class="arg_link">';
                Subtopics::printArticlesList($subtopic['Id']);
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
                echo '<li><a href="#LAR">'.$subtopic['Title'].'</a></li>';
            }
            //Stampa form di aggiunta
            echo '</ul>';
            //Destroy the object
            $connection = NULL;
        }

        static function printInsertSubtopicForm($sessionEmail){
            if(User::isAdmin($sessionEmail)){
                echo '<form action="index.php">
                    <p>Inserisci un nuovo sotto-argomento</p>
                    <input type="text" name="argomento" /><br />
                    <input type="submit" value="Invia" />
                </form>';
            }else{ //TOREMOVE
                echo '(Non puoi inserire un nuovo sotto-argomento)';
            }
        }
    }

?>