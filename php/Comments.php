<?php
    include_once ("Connection.php");
    include_once ("User.php");
    class Comments {

        //Function that print the input box to add a comment if the user is logged
        static function printCommentInputZone($loggedUserEmail){
            if(isset($loggedUserEmail)) { //L'utente è loggato
                if(isset($_SESSION['userInfo'])) {
                    $nickname = unserialize($_SESSION['userInfo'])->nickname;
                    if(User::isBanned($nickname)) {
                        if(User::isAdmin($loggedUserEmail)) {
                            echo '<h2>Your account has been suspended, so you can not leave a comment.<br/>
                            As an admin, you can no longer delete comments from other users...</h2>';
                        } else {
                            echo '<h2>Your account has been suspended, so you can not leave a comment.</h2>';
                        }
                        return;
                    }
                }
                $connection = new Connection();
                $connection -> prepareQuery("SELECT * FROM USERS WHERE :email = Email");
                $connection->bindParameterToQuery(":email", $loggedUserEmail, PDO::PARAM_STR);
                $result = $connection -> executeQuery();
                echo '<div id="comments-error-box-insert-comment"></div>
                <form action="'.$_SERVER['REQUEST_URI'].'" method="POST" id="insert-new-comment-form">
                <fieldset>';
                echo '<p>
                    <label for="comment-text-area-input">Add a comment to this article</label>
                    <textarea rows="10" cols="100" placeholder="Write a comment..." name="comment-input" id="comment-text-area-input" required onfocus="ReadArticle_HideInsertCommentError()"></textarea>
                    </p>
                        <p><input name="comment" type="submit" value="Send comment" /></p>';
                echo '</fieldset></form>';
            }else{
                echo '<h2>Please, login or register to comment this article...</h2>';
            }
            //Destroy the object
            $connection = NULL;
        }

        static function getCommentVoteNumber($commentID){
            $connection = new Connection();
            //Conteggio dei voti positivi/negativi del commento corrente
            $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE :commID = CommentID");
            $connection->bindParameterToQuery(":commID", $commentID, PDO::PARAM_STR);
            $commentVotes = $connection -> executeQuery();

            $totalVotes = 0;
            foreach ($commentVotes as $vote){
                if($vote['is_like']){
                    $totalVotes = $totalVotes + 1;
                }else{
                    $totalVotes = $totalVotes - 1;
                }
            }
            //Destroy the object
            $connection = NULL;
            //return the value
            return $totalVotes;
        }

        static function printAllComments($articleID, $loggedUserEmail){
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM COMMENTS WHERE ".$articleID." = ArticleID ORDER BY Date DESC");
            $result = $connection -> executeQuery();

            $loggedUserIsAdmin = User::isAdmin($loggedUserEmail);
            //Print all comments with a foreach
            foreach ($result as $comment){
                //Per ogni commento prendi l'autore e le sue informazioni
                $connection -> prepareQuery("SELECT * FROM USERS WHERE :email = Email");
                $connection->bindParameterToQuery(":email", $comment['AuthorID'], PDO::PARAM_STR);
                $commentAuthor = $connection -> executeQuery();

                $nickname = unserialize($_SESSION['userInfo'])->nickname;
                $is_banned = User::isBanned($nickname);

                echo '<span id="comment_'.$comment['Id'].'"></span>';
                echo '<div class="comment">';
                    echo '<div class="comment-header">';
                        echo '<p class="comment-username">'.$commentAuthor[0]['Nickname'].'</p>';

                        //Prendo le informazioni relative all'utente loggato per vedere se HA GIA' votato il commento corrente
                        $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE :email = AuthorID AND :commID = CommentID");
                        $connection->bindParameterToQuery(":commID", $comment['Id'], PDO::PARAM_STR);
                        $connection->bindParameterToQuery(":email", $loggedUserEmail, PDO::PARAM_STR);
                        $loggedUserVote = $connection -> executeQuery();

                        if(isset($loggedUserEmail) && !$is_banned){
                            //Stampo un'immagine differente se ha già votato con un dislike
                            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="vote-form">';
                            echo '<input type="hidden" name="commentID" value="'.$comment['Id'].'" />';
                            if(isset($loggedUserVote[0]) && !$loggedUserVote[0]['is_like']) {
                                echo '<input type="hidden" name="delete-vote" />';
                                echo '<input type="image" alt="Pulsante non mi piace - già votato" src="https://frncscdf.github.io/Tecnologie-Web/img/dislike-red.svg" class="vote-button vote-button-dislike" />';
                            }else{
                                echo '<input type="hidden" name="isLike" value="0" />';
                                echo '<input type="hidden" name="vote-comment" />';
                                echo '<input type="image" alt="Pulsante non mi piace" src="https://frncscdf.github.io/Tecnologie-Web/img/dislike.svg" class="vote-button vote-button-dislike" />';
                            }
                            echo '</form>';
                        }else{ //Form non funzionante per utente non loggato
                            echo '<form class="vote-form">';
                            echo '<input type="image" alt="Pulsante non mi piace" src="https://frncscdf.github.io/Tecnologie-Web/img/dislike.svg" disabled class="vote-button-disabled vote-button-dislike" />';
                            echo '</form>';
                        }

                        //-------------
                        $totalVotes = Comments::getCommentVoteNumber($comment['Id']);

                        //Stampo il conto dei voti in positivo/negativo
                        if($totalVotes >= 0){
                            echo '<p class="comment-vote positive-vote">'.$totalVotes.'</p>';
                        }else{
                            echo '<p class="comment-vote negative-vote">'.$totalVotes.'</p>';

                        }

                        //-------------
                        if(isset($loggedUserEmail) && !$is_banned){
                            //Stampo un'immagine differente se ha già votato con un like
                            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="vote-form">';
                            echo '<input type="hidden" name="commentID" value="'.$comment['Id'].'" />';
                            if(isset($loggedUserVote[0]) && $loggedUserVote[0]['is_like']) {
                                echo '<input type="hidden" name="delete-vote" />';
                                echo '<input type="image" alt="Pulsante mi piace - già votato" src="https://frncscdf.github.io/Tecnologie-Web/img/like-green.svg" class="vote-button vote-button-like" />';
                            }else{
                                echo '<input type="hidden" name="isLike" value="1" />';
                                echo '<input type="hidden" name="vote-comment" />';
                                echo '<input type="image" alt="Pulsante mi piace" src="https://frncscdf.github.io/Tecnologie-Web/img/like.svg" class="vote-button vote-button-like" />';
                            }
                            echo '</form>';
                        }else{ //Form non funzionante per utente non loggato
                            echo '<form class="vote-form">';
                            echo '<input type="image" alt="Pulsante mi piace" src="https://frncscdf.github.io/Tecnologie-Web/img/like.svg" disabled class="vote-button-disabled vote-button-like" />';
                            echo '</form>';
                        }
                    echo '</div>';
                    echo '<div class="comment-date">';
                        echo '<img src="img/clock.svg" alt="clock"/>';
                        echo '<p>'.date("j/n/Y H:i", strtotime($comment['Date'])).'</p>';
                    echo '</div>';
                    echo '<p class="comment-text">';
                        echo $comment['Text']; //Stampa contenuto effettivo commento
                    echo '</p>';
                    //-------------
                    //Se l'utente è admin aggiungi la possibilità di eliminare un commento
                    if($loggedUserIsAdmin || ($comment['AuthorID'] == $loggedUserEmail)){
                        if(isset($_SESSION['userInfo'])) {
                            if(!$is_banned) {
                                echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="vote-form">';
                                echo '<fieldset>';
                                echo '<input type="hidden" name="commentID" value="'.$comment['Id'].'" />';
                                echo '<p><input type="submit" name="delete-comment" value="Delete comment" class="delete-comment-link" /></p>';
                                echo '</fieldset>';
                                echo '</form>';
                            }
                        }

                    }
                echo '</div>';
            }//end for print all comments

            //Destroy the object
            $connection = NULL;
        }

    }

?>
