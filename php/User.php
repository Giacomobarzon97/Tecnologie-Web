<?php
    include_once ("Connection.php");
    class User {

        static function checkFields($email, $nickname, $password, $name, $surname) {
            // Remove all illegal characters from email
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
        
    }

?>
