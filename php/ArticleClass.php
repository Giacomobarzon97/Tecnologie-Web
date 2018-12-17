<?php
    include_once ("Connection.php");

    class Article {

        static function checkIfArticleExist($articleID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM ARTICLES WHERE ".$articleID." = Id");
            $result = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            if(isset($result[0])) {
                return true;
            }else{
                return false;
            }
        }

        static function printArticleHTML($articleID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM ARTICLES WHERE ".$articleID." = Id");
            $result = $connection -> executeQuery();
            $connection -> prepareQuery("SELECT Nickname FROM USERS WHERE :email = Email");
            $connection->bindParameterToQuery(":email", $result[0]['AuthorID'], PDO::PARAM_STR);
            $author = $connection -> executeQuery();
            //Destroy the object
            $connection = NULL;
            echo '<h2>'.$result[0]['HTMLCode'].'</h2>';
            echo '<!--Inizio paragrafo-->
            <div class="content-paragraph">';
            echo $result[0]['HTMLCode'];
            echo '<p class="article-author">Autore:'.$author[0]['Nickname'].'</p>';
            echo '</div>';
        }
    }

?>