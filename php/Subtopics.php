<?php
    include_once ("Connection.php");
    include_once ("User.php");
    
    class Subtopics {

        static function checkIfTopicExists($topicID){
            if((!is_numeric($topicID))){
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
                    <form>
                        <input type="hidden" name="delete-article" />
                        <input type="hidden" name="articleID" value="0" />
                        <input type="image" alt="cestino elimina link" src="https://frncscdf.github.io/Tecnologie-Web/img/waste-bin.svg" class="delete_button_link" />
                    </form>
                    </div>';
                }
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
                    echo '<form>
                            <input type="hidden" name="delete-subtopic" />
                            <input type="hidden" name="subtopicID" value="0" />
                            <input type="image" alt="cestino elimina sotto-argomento" src="https://frncscdf.github.io/Tecnologie-Web/img/waste-bin.svg" class="delete_button_gen" />
                        </form>
                        <form>
                            <input type="image" alt="aggiunta sotto-argomento" src="https://frncscdf.github.io/Tecnologie-Web/img/edit.svg" class="add_button_gen" />
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
