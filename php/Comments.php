<?php
    include_once ("Connection.php");
    include_once ("User.php");
    class Comments {

        //Function that print the input box to add a comment if the user is logged
        static function printCommentInputZone($loggedUserEmail){
            if(isset($loggedUserEmail)) { //L'utente è loggato
                $connection = new Connection();
                $connection -> prepareQuery("SELECT * FROM USERS WHERE :email = Email");
                $connection->bindParameterToQuery(":email", $loggedUserEmail, PDO::PARAM_STR);
                $result = $connection -> executeQuery();
                echo '<div class="input-comment">
                    <div class="input-comment-avatar">
                        <img src="'.$result[0]['ProfilePic'].'" alt="Avatar di '.$result[0]['Nickname'].'"/>
                    </div>
                    <div class="input-comment-area">
                            <textarea rows="4" cols="200" name="comment-input"></textarea>
                    </div>
                    <div class="input-comment-footer">
                        <input name="comment" type="submit" value="Invia commento" />
                    </div>
                </div>';
            }else{
                echo '<div class="input-comment">
                <h4>Per favore esegui il login o registrati per commentare</h4>
                </div>';
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
            //Print all comments with a foreach
            foreach ($result as $comment){
                //Per ogni commento prendi l'autore e le sue informazioni
                $connection -> prepareQuery("SELECT * FROM USERS WHERE :email = Email");
                $connection->bindParameterToQuery(":email", $comment['AuthorID'], PDO::PARAM_STR);
                $commentAuthor = $connection -> executeQuery();

                echo '<div class="post-comment">';
                echo '<span id="'.$comment['Id'].'"></span>';
                    echo '<div class="post-comment-avatar">
                    <img src="'.$commentAuthor[0]['ProfilePic'].'" alt="Avatar di '.$commentAuthor[0]['Nickname'].'"/>
                    </div>';
                    echo '<div class="post-comment-body">';
                        echo '<div class="post-comment-body-header">';
                            echo '<div class="post-comment-header-info">';
                                echo '<h4>'.$commentAuthor[0]['Nickname'].'</h4>';
                                echo '<p>'.date("H:i:s j/n/Y", strtotime($comment['Date'])).'</p>';
                            echo '</div>
                            <div class="post-comment-body-header-votes">';

                                //Prendo le informazioni relative all'utente loggato per vedere se HA GIA' votato il commento corrente
                                $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE :email = AuthorID AND :commID = CommentID");
                                $connection->bindParameterToQuery(":commID", $comment['Id'], PDO::PARAM_STR);
                                $connection->bindParameterToQuery(":email", $loggedUserEmail, PDO::PARAM_STR);
                                $loggedUserVote = $connection -> executeQuery();

                                if(isset($loggedUserEmail)){
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
                                    echo '<p class="positive-vote">'.$totalVotes.'</p>';
                                }else{
                                    echo '<p class="negative-vote">'.$totalVotes.'</p>';

                                }

                                //-------------
                                if(isset($loggedUserEmail)){
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
                            echo '</div>
                        </div>';
                        echo '<div class="post-comment-body-content">
                            <p>';
                                echo $comment['Text']; //Stampa contenuto effettivo commento
                            echo '</p>
                        </div>';
                        //-------------
                        //Se l'utente è admin aggiungi la possibilità di eliminare un commento
                        echo '<div class="post-comment-body-footer">';
                        if(User::isAdmin($loggedUserEmail) || ($comment['AuthorID'] == $loggedUserEmail)){
                            echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="vote-form">';
                            echo '<input type="hidden" name="commentID" value="'.$comment['Id'].'" />';
                            echo '<input type="submit" name="delete-comment" value="Elimina il commento" class="delete-comment-link" />';
                            echo '</form>';
                        }
                        echo '</div>';
                    echo '</div>
                </div>';
            }//end for print all comments

            //Destroy the object
            $connection = NULL;
        }

    }

?>
