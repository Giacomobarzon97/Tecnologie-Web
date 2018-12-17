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
                        <input type="submit" value="Invia commento" />
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
                    echo '<div class="post-comment-avatar">
                    <img src="'.$commentAuthor[0]['ProfilePic'].'" alt="Avatar di '.$commentAuthor[0]['Nickname'].'"/>
                    </div>';
                    echo '<div class="post-comment-body">';
                        echo '<div class="post-comment-body-header">';
                            echo '<div class="post-comment-header-info">';
                                echo '<h4>'.$commentAuthor['Nickname'].'</h4>';
                                echo '<p>'.date("H:i:s j/n/Y", strtotime($comment['Date'])).'</p>';
                            echo '</div>
                            <div class="post-comment-body-header-votes">';

                                //Prendo le informazioni relative all'utente loggato per vedere se HA GIA' votato il commento corrente
                                $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE :email = AuthorID AND :commID = CommentID");
                                $connection->bindParameterToQuery(":commID", $comment['Id'], PDO::PARAM_STR);
                                $connection->bindParameterToQuery(":email", $loggedUserEmail, PDO::PARAM_STR);
                                $loggedUserVote = $connection -> executeQuery();

                                //Stampo un'immagine differente se ha già votato con un dislike
                                if(isset($loggedUserVote[0]) && !$loggedUserVote[0]['is_like']) {
                                    echo '<img src="https://frncscdf.github.io/Tecnologie-Web/img/dislike.svg" class="dislike-vote" alt="dislike comment button" />';
                                }else{
                                    echo '<img src="https://frncscdf.github.io/Tecnologie-Web/img/dislike.svg" class="dislike-vote" alt="dislike comment button" />';
                                }

                                //-------------
                                //Conteggio dei voti positivi/negativi del commento corrente
                                $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE :commID = CommentID");
                                $connection->bindParameterToQuery(":commID", $comment['Id'], PDO::PARAM_STR);
                                $commentVotes = $connection -> executeQuery();

                                $totalVotes = 0;
                                foreach ($commentVotes as $vote){
                                    if($vote['is_like']){
                                        $totalVotes = $totalVotes + 1;
                                    }else{
                                        $totalVotes = $totalVotes - 1;
                                    }
                                }

                                //Stampo il conto dei voti in positivo/negativo
                                if($totalVotes >= 0){
                                    echo '<p class="positive-vote">'.$totalVotes.'</p>';
                                }else{
                                    echo '<p class="negative-vote">'.$totalVotes.'</p>';

                                }

                                //-------------
                                //Stampo un'immagine differente se ha già votato con un like
                                if(isset($loggedUserVote[0]) && $loggedUserVote[0]['is_like']) {
                                    echo '<img src="https://frncscdf.github.io/Tecnologie-Web/img/like.svg" class="like-vote" alt="like comment button" />';
                                }else{
                                    echo '<img src="https://frncscdf.github.io/Tecnologie-Web/img/like.svg" class="like-vote" alt="like comment button" />';
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
                        if(User::isAdmin($loggedUserEmail)){
                            echo '<input type="submit" value="Elimina il commento" class="comment-reply-start-button" />';
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