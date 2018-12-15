<?php
    include_once ("Connection.php");
    class User {

        private function checkFields() {

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

            try {
                $result = $connection -> executeQueryDML();
                echo "Registrazione avvenuta con successo"; 
            } catch (PDOException $e){
                echo $e->getMessage();
                echo "Utente già esistente";
            }
            
            $connection = NULL;
        }
        
    }

    User::registration('test@m.b', 'lol', 'ciao', 'a', 'b');

?>
