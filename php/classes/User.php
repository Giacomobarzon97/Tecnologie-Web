<?php
    include_once ("Connection.php");
    class User {

        static function checkFields($email, $nickname, $password, $name, $surname) {
            // Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
                echo "email non valida";
                return false;
            }

            if($nickname === '' || strlen($nickname) > 100) {
                echo "username non valido";
                return false;
            }

            if($password === '' || strlen($nickname) > 100) {
                echo "password non valido";
                return false;
            }

            if($name === '' || strlen($name > 100)) {
                echo "nome non valido";
                return false;
            }

            if($surname === '' || strlen($surname) > 100) {
                echo "cognome non valido";
                return false;
            }

            return true;
        }
        
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

            $fieldValidity = User::checkFields($email, $nickname, $password, $name, $surname);
            if(!$fieldValidity) {
                echo "controlla i campi!";
            }

            try {
                $result = $connection -> executeQueryDML();
                //echo "Registrazione avvenuta con successo"; 
            } catch (PDOException $e){
                //echo $e->getMessage();
                
            }
            
            $connection = NULL;
        }

        static function login() {
            /*$sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute([$_POST['username']]);
            $users = $result->fetchAll();
            if (isset($users[0]) {
                if (password_verify($_POST['password'], $users[0]->password) {
                    // valid login
                } else {
                    // invalid password
                }
            } else {
                // invalid username
            }*/

        }
        
    }

?>
