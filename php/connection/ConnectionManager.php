<?php
    class ConnectionManager {
        private $hostname = NULL;
        private $username = NULL;
        private $password = NULL;
        private $databaseName = NULL;
        private $charset = NULL;
        
        private function readDataFromJSON(){
            $content = file_get_contents("../loginData.json");
            $json = json_decode($content, true);

            $this->hostname = $json['hostname'];
            $this->username = $json['username'];
            $this->password = $json['password'];
            $this->databaseName = $json['databaseName'];
            $this->charset = $json['charset'];
        }

        private function connect() {
            try {
                $this->readDataFromJSON();
                $dbh = new PDO("mysql:host=$this->hostname;dbname=$this->databaseName;", $this->username, $this->password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $dbh;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        public function executeQuery($query) {
            $dbh = $this->connect();
            $stmt = $this->prepare($query);
            $stmt->execute();
            $query->bind_result($result);
            echo $result;
        }


    }

    $conn = new ConnectionManager();
    $conn->executeQuery('SELECT * FROM USERS');
?>