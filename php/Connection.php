<?php
    class Connection {
        private $hostname = NULL;
        private $username = NULL;
        private $password = NULL;
        private $databaseName = NULL;
        private $charset = NULL;

        //Database connection
        private $dbh = NULL;
        //Current query being prepared
        private $currentQuery = NULL;
        
        private function readDataFromJSON(){
            $content = file_get_contents("loginData.json");
            $json = json_decode($content, true);

            $this->hostname = $json['hostname'];
            $this->username = $json['username'];
            $this->password = $json['password'];
            $this->databaseName = $json['databaseName'];
            $this->charset = $json['charset'];
        }

        //The constructor read the data from the JSON and connect to the database
        function __construct() {
            //echo "constructor start<br/>";
            $this->readDataFromJSON();
            $this->connect();
            //echo "constructor done<br/>";
        }

        //The destructor disconnect from the database
        function __destruct() {
            //echo "destructor start<br/>";
            $this->disconnect();
            //echo "destructor done<br/>";
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

        //Function that prepare the given query
        //Remember that may delete a not-executed query, prepared before
        public function prepareQuery($query){
            if(!is_null($this->currentQuery)){
                $this->currentQuery = NULL;
            }
            $this->currentQuery = $this->dbh->prepare($query);
        }

        //Function that bind a parameter in the query
        //List of data types: http://php.net/manual/en/pdo.constants.php
        public function bindParameterToQuery($paramName, $paramValue, $data_type){
            if(!is_null($this->currentQuery)){
                $this->currentQuery->bindParam($paramName, $paramValue, $data_type);
            }
        }

        //Function that execute the query and return the result
        public function executeQuery() {
            if(is_null($this->currentQuery)){
                return NULL;
            }else{
                //Execute the query
                $this->currentQuery->execute();
                //May not be necessary, check if is necessary to delete the prepared query
                $returnValue = $this->currentQuery->fetchAll();
                $currentQuery = NULL;
                return $returnValue;
            }
        }

        public function executeQueryDML() {
            if(is_null($this->currentQuery)){
                return NULL;
            }else{
                //Execute the query
                $returnValue = $this->currentQuery->execute();
                $currentQuery = NULL;
                return $returnValue;
            }
        }

    }
    
?>