<?php
    class ConnectionManager {
        private $hostname = NULL;
        private $username = NULL;
        private $password = NULL;
        private $databaseName = NULL;
        private $charset = NULL;

        private $dbh = NULL;
        
        private function readDataFromJSON(){
            $content = file_get_contents("../loginData.json");
            $json = json_decode($content, true);

            $this->hostname = $json['hostname'];
            $this->username = $json['username'];
            $this->password = $json['password'];
            $this->databaseName = $json['databaseName'];
            $this->charset = $json['charset'];
        }

        //The constructor read the data from the JSON and connect to the database
        function __construct() {
            echo "constructor start<br/>";
            $this->readDataFromJSON();
            $this->connect();
            echo "constructor done<br/>";
        }

        //The destructor disconnect from the database
        function __destruct() {
            echo "destructor start<br/>";
            $this->disconnect();
            echo "destructor done<br/>";
        }

        private function connect() {
            try {
                $this->readDataFromJSON();
                $this->dbh = new PDO("mysql:host=$this->hostname;dbname=$this->databaseName;", $this->username, $this->password);
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        private function disconnect(){
            $this->dbh = NULL;
        }

        public function executeQuery($query) {
            //Execute the query
            $query->execute();
            //May not be necessary, check if is necessary to delete the prepared query
            $returnValue = $query->fetchAll();
            $query = NULL;
            return $returnValue;
        }

        public function getConnection(){
            return $this->dbh;
        }

    }

    //Create the Object
    $conn = new ConnectionManager();
    //Get the connection
    $database_conn = $conn->getConnection();
    //Prepare and execute the query
    $result = $conn->executeQuery($database_conn->prepare('SELECT * FROM USERS'));
    //Print the test results
    foreach ($result as $item) {
        echo $item['Nickname'].'<br/>';
    }
    //Destroy the objecy
    $conn = NULL;
?>