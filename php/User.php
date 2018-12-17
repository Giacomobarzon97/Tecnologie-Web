<?php
    include_once ("Connection.php");
    class User {

        static function checkFields($email, $nickname, $password, $name, $surname) {
            // Rimuove i caratteri che non possono figurare in un indirizzo email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
                //echo "email non valida";
                return false;
            }

            if($nickname === '' || strlen($nickname) > 100) {
                //echo "username non valido";
                return false;
            }

            if($password === '' || strlen($nickname) > 100) {
                //echo "password non valido";
                return false;
            }

            if($name === '' || strlen($name > 100)) {
                //echo "nome non valido";
                return false;
            }

            if($surname === '' || strlen($surname) > 100) {
                //echo "cognome non valido";
                return false;
            }

            return true;
        }
        
        /*
            Viene ritornato un messagio che specifica lo stato dopo aver tentato la registrazione
        */
        static function registration($email, $nickname, $password, $name, $surname) {
            $connection = new Connection();
            $profilePic = "https://frncscdf.github.io/Tecnologie-Web/img/coding.svg";
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $connection -> prepareQuery
            ("INSERT INTO USERS(Email, Nickname, Password, Name, Surname, ProfilePic) 
            VALUES (:Email, :Nickname, :Password, :Name, :Surname, :ProfilePic)");
            $connection->bindParameterToQuery(":Email", $email, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":Nickname", $nickname, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":Password", $hashPassword, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":Name", $name, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":Surname", $surname, PDO::PARAM_STR);
            $connection->bindParameterToQuery(":ProfilePic", $profilePic, PDO::PARAM_STR);

            $messagge = NULL;

            $fieldValidity = User::checkFields($email, $nickname, $password, $name, $surname);
            if(!$fieldValidity) {
                $messagge = "Campi non validi!";
            } else {
                try {
                    $result = $connection -> executeQueryDML();
                    $messagge = "Registrazione avvenuta con successo! <br/>
                                Clicca <a href='login.php'>qui</a> per eseguire il login.";
                } catch (PDOException $e){
                    $messagge = "Impossibile registrarsi, utente già esistente!";
                }
            }
            
            $connection = NULL;
            return $messagge;
        }

        /*
            Viene ritornato true se il login ha avuto successo, false altrimenti
        */
        static function login($email, $password) {
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM USERS WHERE Email = :email");
            $connection -> bindParameterToQuery(":email", $email, PDO::PARAM_STR);
            $result = $connection -> executeQuery();
            
            if(isset($result[0])) {
                if(password_verify($password, $result[0]['Password'])) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        static function getNickname($email) {
            $connection = new Connection();
            $connection -> prepareQuery("SELECT Nickname FROM USERS WHERE Email = :email");
            $connection -> bindParameterToQuery(":email", $email, PDO::PARAM_STR);
            $result = $connection -> executeQuery();
            return $result[0]['Nickname'];
        }

        static function isAdmin($email) {
            if(!isset($email)) {
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery(
            "SELECT * FROM USERS, USER_ROLES WHERE  
            USERS.Email = USER_ROLES.UserID AND USER_ROLES.UserID ='".$email."'");
            $result = $connection -> executeQuery();
            if(isset($result[0]) == 1) {
                return true;
            } else {
                return false;
            }
        }
        
        //ritorna un messaggio se l'inserimento non va a buon fine
        static function addComment($articleID, $commentText, $authorID) {
            if(strlen($commentText) > 10000) {
                return "Impossibile inserire articolo, troppo lungo!";
            } else if($commentText == "") {
                return "Impossibile inserire articolo, commento vuoto!";
            }
            $connection = new Connection();
            $connection -> prepareQuery(
                "INSERT INTO COMMENTS (Text, Date, AuthorID, ArticleID)
                VALUES (:commentText, NOW(), '$authorID', '$articleID')");
                $connection->bindParameterToQuery(":commentText", $commentText, PDO::PARAM_STR);
                try {
                    $result = $connection -> executeQueryDML();
                    header("Location: Article.php?id=$articleID#comments-content");
                } catch (PDOException $e){
                    
                }
        }

        static function deleteComment($email, $commentID) {
            if(User::isAdmin($email)) {
                $connection = new Connection();
                $connection -> prepareQuery(
                "DELETE FROM COMMENTS WHERE Id = '$commentID'");
                try {
                    $result = $connection -> executeQueryDML();
                } catch (PDOException $e){
                    
                }
            }
        }

        static function voteComment($commentID, $userVoteID, $isLike) {
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE CommentID = $commentID AND AuthorID = '$userVoteID'");
            //If user has already voted remove his vote
            if(isset($connection->executeQuery()[0])){
                User::removeVoteComment($commentID, $userVoteID, false);
            }
            $connection -> prepareQuery(
                "INSERT INTO COMMENTS_VOTES (CommentID, AuthorID, is_like)
                VALUES ('$commentID', '$userVoteID', '$isLike')"
            );
            $result = $connection -> executeQueryDML();
            header("Location: Article.php?id=$articleID#".$commentID);
        }

        static function removeVoteComment($commentID, $userVoteID, $shouldRedirect) {
            $connection = new Connection();
            $connection -> prepareQuery(
                "DELETE FROM COMMENTS_VOTES WHERE CommentID = $commentID AND AuthorID = '$userVoteID'"
            );
            $result = $connection -> executeQueryDML();
            if($shouldRedirect){ //Inutile da usare quando usato da voteComment() no?
                header("Location: Article.php?id=$articleID#".$commentID);
            }
        }

        //ritorna un messaggio che notifica la riuscita o meno del cambio della password
        static function changePassword($email, $oldPassword, $newPassword) {
            $connection = new Connection();
            $connection -> prepareQuery(
                "SELECT * FROM USERS WHERE Email = '$email'"
            );

            $result = $connection -> executeQuery();
            $oldPasswordHash = password_hash($oldPassword, PASSWORD_DEFAULT);
            if($result[0]['Password'] != $oldPasswordHash) {
                return "Attenzione, le due password non coincidono!";
            }

            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $connection -> prepareQuery(
                "UPDATE USERS SET Password = '$newPasswordHash' WEHERE Password = '$oldPasswordHash'"
            );

            try {
                $result = $connection -> executeQueryDML();
                return "Password aggiornata con successo!";
            } catch (PDOException $e){
                
            }
            
        }

        static function deleteAccount($email) {
            //controllare che cancelli il suo e non quello di un altro utente
            $connection = new Connection();
            $connection -> prepareQuery(
                "DELETE FROM USERS WHERE Email = '$email'");
                try {
                    $result = $connection -> executeQueryDML();
                } catch (PDOException $e){
                    
                }
        }
        
    }

?>
