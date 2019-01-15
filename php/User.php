<?php
    include_once ("Connection.php");
    include_once ("validateData.php");

    class UserInfo {
        public $email = "";
        public $nickname = "";
        public $name = "";
        public $surname = "";

        function __construct($e, $nick, $na, $s) {
            $this->email = $e;
            $this->nickname = $nick;
            $this->name = $na;
            $this->surname = $s;
        }
    }

    class User {

        static function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        private static function sendEmail($email, $content, $subject){

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=UTF-8';

            mail($email, $subject, $content, implode("\r\n", $headers));
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

            $messagge = "";

            if(!ValidateData::validateEmail($email)) {
                $messagge = "<p>E-mail non valida!</p>";
            }
            if(!ValidateData::checkStringIsEmpty($nickname)) {
                $messagge = "<p>Nickname non valido!</p>";
            }
            if(!ValidateData::validatePassword($password)) {
                $messagge = "<p>Password non valida! Deve essere lunga tra 3 e 100 caratteri</p>";
            }
            if(!ValidateData::validateName($name)) {
                $messagge = "<p>Nome non valido!</p>";
            }
            if(!ValidateData::validateName($surname)) {
                $messagge = "<p>Cognome non valido!</p>";
            }
            if ($messagge == "") {
                try {
                    $result = $connection -> executeQueryDML();
                    $messagge = "Registrazione avvenuta con successo! <br/>
                                Clicca <a href='login.php'>qui</a> per eseguire il login.";
                } catch (PDOException $e){
                    $messagge = "Impossibile registrarsi, utente già esistente o nickname già presente!";
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
            $connection = NULL;
            if(isset($result[0])) {
                if(password_verify($password, $result[0]['Password'])) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        static function getUserInfo($email) {
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM USERS WHERE Email = :email");
            $connection -> bindParameterToQuery(":email", $email, PDO::PARAM_STR);
            $result = $connection -> executeQuery();
            $nickname = $result[0]['Nickname'];
            $name = $result[0]['Name'];
            $surname = $result[0]['Surname'];
            
            $userInfo = new UserInfo($email, $nickname, $name, $surname);
            return $userInfo;
        }

        static function isAdmin($email) {
            if(!isset($email)) {
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery(
            "SELECT * FROM USERS, USER_ROLES WHERE  
            USERS.Email = USER_ROLES.UserID AND USER_ROLES.UserID ='".$email."'
            AND USER_ROLES.RoleName = 'Admin User'");
            $result = $connection -> executeQuery();
            $connection = NULL;
            if(isset($result[0]) == 1) {
                return true;
            } else {
                return false;
            }
        }

        //--------------------------------------------------------
        //Funzioni per i commenti
        //--------------------------------------------------------
        
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
            $result = $connection -> executeQueryDML();
            $connection = NULL;
        }

        static function deleteComment($email, $commentID) {
            $connection = new Connection();
            if(User::isAdmin($email)) {
                $connection -> prepareQuery(
                "DELETE FROM COMMENTS WHERE Id = '$commentID'");
                $result = $connection -> executeQueryDML();
            }else{
                $connection -> prepareQuery(
                "DELETE FROM COMMENTS WHERE Id = '$commentID' AND AuthorID = '$email'");
                $result = $connection -> executeQueryDML();
            }
            $connection = NULL;
        }

        static function redirectToComment($articleID, $commentID){
            echo '<script>';
            echo 'window.location.replace("ReadArticle.php?id='.$articleID.'#'.$commentID.'");';
            echo '</script>';
        }

        static function voteComment($commentID, $userVoteID, $isLike, $articleID) {
            $connection = new Connection();
            $connection -> prepareQuery("SELECT * FROM COMMENTS_VOTES WHERE CommentID = $commentID AND AuthorID = '$userVoteID'");
            //If user has already voted remove his vote
            if(isset($connection->executeQuery()[0])){
                User::removeVoteComment($commentID, $userVoteID, $articleID, false);
            }
            $connection -> prepareQuery(
                "INSERT INTO COMMENTS_VOTES (CommentID, AuthorID, is_like)
                VALUES ('$commentID', '$userVoteID', '$isLike')"
            );
            $result = $connection -> executeQueryDML();
            User::redirectToComment($articleID, $commentID);
        }

        static function removeVoteComment($commentID, $userVoteID, $articleID, $shouldRedirect = true) {
            $connection = new Connection();
            $connection -> prepareQuery(
                "DELETE FROM COMMENTS_VOTES WHERE CommentID = $commentID AND AuthorID = '$userVoteID'"
            );
            $result = $connection -> executeQueryDML();
            if($shouldRedirect){ //Inutile da usare quando usato da voteComment() no?
                User::redirectToComment($articleID, $commentID);
            }
        }

        //--------------------------------------------------------
        //Funzioni per cambiare dettagli utente
        //--------------------------------------------------------

        //ritorna un messaggio che notifica la riuscita o meno del cambio della password
        static function changePassword($email, $oldPassword, $newPassword, $confNewPassword) {
            //CONTROLLARE VALIDITA' DELLA PASSWORD
            if($newPassword != $confNewPassword) {
                return "Attenzione, la nuova password e la conferma non coincidono!";
            }
            $connection = new Connection();
            $connection -> prepareQuery(
                "SELECT * FROM USERS WHERE Email = '$email'"
            );

            $result = $connection -> executeQuery();
            
            if(isset($result[0])) {
                if(!password_verify($oldPassword, $result[0]['Password'])) {
                    return "Attenzione, la password attuale inserita è errata!";
                } 
            }

            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $oldPasswordHash = $result[0]['Password'];
            $connection -> prepareQuery(
                "UPDATE USERS SET Password = '$newPasswordHash' WHERE Password = '$oldPasswordHash'"
            );

            $result = $connection -> executeQueryDML();
            return "Password aggiornata con successo!";
            
        }

        static function changeNickname($email, $newNickname) {
            if(!ValidateData::checkStringIsEmpty($newNickname)) {
                return false;
            }
            $resultState = true;
            $connection = new Connection();
            try {
                $connection -> prepareQuery(
                    "UPDATE USERS SET Nickname = '$newNickname' WHERE Email = '$email'"
                );
                $result = $connection -> executeQueryDML();
            } catch (PDOException $e) {
                
            }
 
            if(!isset($result)) {
                return false;
            }
            return true;
        }

        static function changeName($email, $newName) {
            if(!ValidateData::validateName($newName)) {
                return false;
            }
            $connection = new Connection();
            try {
                $connection -> prepareQuery(
                    "UPDATE USERS SET Name = '$newName' WHERE Email = '$email'"
                );
                $result = $connection -> executeQueryDML();
            } catch (PDOException $e) {
                
            }
            
            if(!isset($result)) {
                return false;
            }
            return true;
        }

        static function changeSurname($email, $newSurname) {
            if(!ValidateData::validateName($newSurname)) {
                return false;
            }
            $connection = new Connection();
            try {
                $connection -> prepareQuery(
                    "UPDATE USERS SET Surname = '$newSurname' WHERE Email = '$email'"
                );
                $result = $connection -> executeQueryDML();
            } catch (PDOException $e) {
                
            }

            if(!isset($result)) {
                return false;
            }
            return true;
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

        //--------------------------------------------------------
        //Recupero Password Dimenticata
        //--------------------------------------------------------

        static function checkIfTokenExist($token){
            if(!isset($token)){
                return false;
            }
            $connection = new Connection();
            $connection -> prepareQuery(
                "SELECT * FROM FORGOT_PASSWORD_TOKENS WHERE Token = :token"
            );
            //Controllo se il token esiste
            $connection->bindParameterToQuery(":token", $token, PDO::PARAM_STR);
            $result = $connection -> executeQuery();
            
            if(isset($result[0])) { //Se esiste il token
                //Controllo se il token è scaduto confrontando le date
                $today = date("Y-m-d");
                $expire = $result[0]['expireDate'];

                $today_time = strtotime($today);
                $expire_time = strtotime($expire);
                
                if ($expire_time < $today_time) { //Token scaduto
                    //cancello il token scaduto
                    $connection -> prepareQuery("DELETE FROM FORGOT_PASSWORD_TOKENS WHERE Token = '$token'");
                    $result = $connection -> executeQueryDML();
                    //E ritorno false
                    $connection = NULL;
                    return false;
                }else{ //Token non scaduto
                    $connection = NULL;
                    //Controllo che siano uguali
                    if($result[0]['Token'] === $token){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{ //Token non trovato
                return false;
            }
        }

        static function passwordRecover($email){
            $connection = new Connection();
            $connection -> prepareQuery(
                "SELECT * FROM USERS WHERE Email = '$email'"
            );

            $result = $connection -> executeQuery();
            
            if(isset($result[0])) {
                //Add the current user with 7 days from expire date
                $connection -> prepareQuery(
                    "INSERT INTO FORGOT_PASSWORD_TOKENS (UserID, Token, expireDate)
                    VALUES (:userid, :token, (SELECT DATE_ADD(NOW(), INTERVAL 7 DAY)))");
                $recover_token = User::generateRandomString(rand(10, 200));
                $connection->bindParameterToQuery(":userid", $email, PDO::PARAM_STR);
                $connection->bindParameterToQuery(":token", $recover_token, PDO::PARAM_STR);
                $result = $connection -> executeQueryDML();

                $recover_password_link = "http://testsitotecweb.altervista.org/recoverPassword.php?token=".$recover_token;

                //Contenuto email in HTML
                $email_content = '
                    <html>
                        <head>
                            <title>Recupera la password del tuo account</title>
                        </head>
                        <body>
                            <h1>Recupera la password del tuo account</h1>
                            <p>Sembra che tu abbia dimenticato la password :( <br/>
                            Recuperala utilizzando questo link, ricorda che <b>scadra\' tra 7 giorni!</b> <br/>
                            Clicca <a href='.$recover_password_link.'>qui</a> oppure utilizza il link qui sotto:<br/><br/>
                            <a href='.$recover_password_link.'>'.$recover_password_link.'</a></p>

                            <h4>Cordiali saluti, il team del sito</h4>
                        </body>
                    </html>
                ';

                User::sendEmail($email, $email_content, "Recupera la password");

                $connection = NULL;
                return true;
            }else{
                $connection = NULL;
                return false;
            } 
        }//function passwordRecover

        static function passwordRecoveryChange($token, $newPassword){
            $connection = new Connection();
            $connection -> prepareQuery(
                "SELECT * FROM FORGOT_PASSWORD_TOKENS WHERE Token = '$token'"
            );

            $result = $connection -> executeQuery();
            
            if(isset($result[0])) { //Controllo che il token esista
                //Prendo la data di oggi e quella del database
                $today = date("Y-m-d");
                $expire = $result[0]['expireDate'];

                $today_time = strtotime($today);
                $expire_time = strtotime($expire);

                //cancello il token che sto utilizzando
                $connection -> prepareQuery("DELETE FROM FORGOT_PASSWORD_TOKENS WHERE Token = '$token'");
                $result = $connection -> executeQueryDML();

                //Controllo se il token è scaduto
                if ($expire_time > $today_time) { //Token non scaduto
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $user_email = $result[0]['UserID'];
                    $connection -> prepareQuery(
                    "UPDATE USERS SET Password = '$newPasswordHash' WHERE Email = '$user_email'");
                    $result = $connection -> executeQueryDML();
                    //Ritorno true
                    $connection = NULL;
                    return true;
                }else{ //Token scaduto
                    //Ritorno false
                    $connection = NULL;
                    return false;
                }
            }else{
                $connection = NULL;
                return false;
            }
        }//function passwordRecoveryChange
        
    }//Chiusura classe

?>
