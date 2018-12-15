<?php
    include_once ("Connection.php");
    class ArticleLinks {

        static function printArticlesList($subtopicID){
            $connection = new Connection();
            //Prendo Tutti gli articoli
            $connection -> prepareQuery("SELECT * FROM ARTICLES WHERE ".$subtopicID." = SubtopicID");
            $articles = $connection -> executeQuery();
            //Print the test results
            foreach ($articles as $article) {
                echo $article['Title'].' - '.$article['HTMLCode'].'<br/>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function printSubtopicsList($topicID){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM SUBTOPICS WHERE ".$topicID." = TopicID");
            $subtopics = $connection -> executeQuery();
            foreach ($subtopics as $subtopic) {
                echo '<h1>'.$subtopic['Title'].'</h1>';
                echo '<h1>'.$subtopic['Description'].'</h1>';
                ArticleLinks::printArticlesList($subtopic['Id']);
            }
            //Destroy the object
            $connection = NULL;
        }

    }

    ArticleLinks::printSubtopicsList(1);

?>