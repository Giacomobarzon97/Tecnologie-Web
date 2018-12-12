<?php
    class ConnectionManager {
        private $hostname=NULL;
        private $username=NULL;
        private $password=NULL;
        private $databaseName=NULL;
        private $charset=NULL;
        
        function readDataFromJSON(){
            $content = file_get_contents("../loginData.json");
            $json = json_decode($content, true);

            $this->hostname = $json['hostname'];
            $this->username = $json['username'];
            $this->password = $json['password'];
            $this->databaseName = $json['databaseName'];
            $this->charset = $json['charset'];
        }

        function testConnection() {
            try {
                $dbh = new PDO("mysql:host=$this->hostname;dbname=$this->databaseName;", $this->username, $this->password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                foreach($dbh->query('SELECT * FROM USERS') as $row) {
                    print_r($row);
                }
                $dbh = null;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

    $conn = new ConnectionManager();
    $conn->readDataFromJSON();
    $conn->testConnection();
?>