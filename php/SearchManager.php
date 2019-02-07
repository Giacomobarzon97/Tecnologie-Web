<?php

include_once ('Subtopics.php');

class SearchElement{
    private $name = NULL;
    private $description = NULL;
    private $link = NULL;

    function __construct($input_name, $input_description, $input_link) {
        $this->name = $input_name;
        $this->description = $input_description;
        $this->link = $input_link;
    }

    function getName(){
        return $this->name;
    }

    function getLink(){
        return $this->link;
    }

    function getDescription(){
        return $this->description;
    }
}

class SearchManager{
    static $min_similarity = 55;

    static function shortDescription($text){
        if(strlen($text)>150){
            return substr($text, 0, 150)."[...]";
        }else{
            return $text;
        }
    }

    static function getTopicsResults($search_term){
        $search_term = strtolower($search_term);
        $connection = new Connection();
        $results = array();
        $connection -> prepareQuery(
            "SELECT * FROM TOPICS"
        );
        $cards = $connection -> executeQuery();
        foreach ($cards as $card) {
            similar_text(strtolower($card['Name']),$search_term,$percent);
            if($percent >= SearchManager::$min_similarity){
                array_push($results, new SearchElement($card['Name'], SearchManager::shortDescription($card['Description']), "ArticleLinks.php?id=".$card['Id']));
            }
        }
        $connection = NULL;
        return $results;
    }

    static function getSubTopicsResults($search_term){
        $search_term = strtolower($search_term);
        $connection = new Connection();
        $results = array();
        $connection -> prepareQuery(
            "SELECT * FROM SUBTOPICS"
        );
        $subtopics = $connection -> executeQuery();
        foreach ($subtopics as $subtopic) {
            similar_text(strtolower($subtopic['Title']),$search_term,$percent);
            if($percent >= SearchManager::$min_similarity){
                array_push($results, new SearchElement($subtopic['Title'], SearchManager::shortDescription($subtopic['Description']), "ArticleLinks.php?id=".Subtopics::getTopicIDFromSubtopic($subtopic['Id'])."#subtopic_".$subtopic['Id']));
            }
        }
        $connection = NULL;
        return $results;
    }

    static function getArticlesResults($search_term){
        $search_term = strtolower($search_term);
        $connection = new Connection();
        $results = array();
        $connection -> prepareQuery(
            "SELECT * FROM ARTICLES"
        );
        $articles = $connection -> executeQuery();
        foreach ($articles as $article) {
            similar_text(strtolower($article['Title']),$search_term,$percent);
            if($percent >= SearchManager::$min_similarity){
                array_push($results, new SearchElement($article['Title'], NULL, "ReadArticle.php?id=".$article['Id']));
            }
        }
        $connection = NULL;
        return $results;
    }
}


?>