<?php
include_once("Connection.php");

class Article
{

    static $allowed_content_tags = '<strong><em><p><h2><h3><h4><ul><ol><li>';

    static function checkIfArticleExist($articleID)
    {
        if ((!is_numeric($articleID))) {
            return false;
        }
        $value = Article::getArticleRowFromId($articleID);
        if (isset($value) && $value != NULL) {
            return true;
        } else {
            return false;
        }
    }

    static function getArticleRowFromId($articleID)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT * FROM ARTICLES WHERE " . $articleID . " = Id");
        $result = $connection->executeQuery();
        //Destroy the object
        $connection = NULL;
        if (isset($result[0])) {
            return $result[0];
        } else {
            return NULL;
        }
    }

    static function printArticleHTML($articleID)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT * FROM ARTICLES WHERE " . $articleID . " = Id");
        $result = $connection->executeQuery();
        $connection->prepareQuery("SELECT Nickname FROM USERS WHERE :email = Email");
        $connection->bindParameterToQuery(":email", $result[0]['AuthorID'], PDO::PARAM_STR);
        $author = $connection->executeQuery();
        //Destroy the object
        $connection = NULL;
        echo '<h1>' . $result[0]['Title'] . '</h1>';
        echo '<!--Inizio paragrafo-->';
        echo $result[0]['HTMLCode'];
        echo '<p id="article-author">Article author: ' . $author[0]['Nickname'] . '</p>';
    }

    static function insertArticleInTable($title, $content, $authorID, $subtopicID)
    {
        if(!isset($title) || strlen($title)<2 || strlen($title)>100 || !ValidateData::checkStringIsEmpty($title)){
            return new ResultManager("<li>The article title is not valid! (Probably is too short/long or empty)</li>", true);
        }
        if(!isset($content) || strlen($content)<2 || strlen($content)>100000 || !ValidateData::checkStringIsEmpty($content)){
            return new ResultManager("<li>The article content is not valid! (Probably is too short/long or empty)</li>", true);
        }
        $connection = new Connection();
        $connection->prepareQuery(
            "INSERT INTO ARTICLES (Title, HTMLCode, AuthorID, SubtopicID)
                VALUES (:title, :code, :authorID, $subtopicID)");
        $connection->bindParameterToQuery(":title", strip_tags($title), PDO::PARAM_STR);
        $connection->bindParameterToQuery(":code", strip_tags($content, Article::$allowed_content_tags), PDO::PARAM_STR);
        $connection->bindParameterToQuery(":authorID", $authorID, PDO::PARAM_STR);
        $result = $connection->executeQueryDML();
        $connection = NULL;
        return NULL;
    }

    static function getArticleTitle($articleID)
    {
        $connection = new Connection();
        $connection->prepareQuery("SELECT * FROM ARTICLES WHERE " . $articleID . " = Id");
        $result = $connection->executeQuery();
        $connection = NULL;
        return $result[0]['Title'];
    }

    static function deleteArticle($articleID)
    {
        $connection = new Connection();
        $connection->prepareQuery(
            "DELETE FROM ARTICLES WHERE Id = $articleID");
        $result = $connection->executeQueryDML();
        $connection = NULL;
    }

    static function editArticle($articleID, $title, $content)
    {
        if(!isset($title) || strlen($title)<2 || strlen($title)>100 || !ValidateData::checkStringIsEmpty($title)){
            return new ResultManager("<li>The article title is not valid! (Probably is too short/long or empty)</li>", true);
        }
        if(!isset($content) || strlen($content)<2 || strlen($content)>100000 || !ValidateData::checkStringIsEmpty($content)){
            return new ResultManager("<li>The article content is not valid! (Probably is too short/long or empty)</li>", true);
        }
        $connection = new Connection();
        $connection->prepareQuery(
            "UPDATE ARTICLES SET Title = :title , HTMLCode = :code WHERE Id = $articleID");
        $connection->bindParameterToQuery(":title", strip_tags($title), PDO::PARAM_STR);
        $connection->bindParameterToQuery(":code", strip_tags($content, Article::$allowed_content_tags), PDO::PARAM_STR);
        $result = $connection->executeQueryDML();
        $connection = NULL;
        return NULL;
    }
}

?>
