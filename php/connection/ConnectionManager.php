<?php
    class ConnectionManager {
        private $hostname='localhost';
        private $username='testsitotecweb';
        private $password='SitoTecWeb2018';
        private $databaseName='my_testsitotecweb';
        private $charset='utf8mb4';

        private $dsn = 'mysql:host=localhost;dbname=my_testsitotecweb;';
        
        static function testConnection() {
            try {
                $dbh = new PDO('mysql:host=localhost;dbname=my_testsitotecweb;', $username, $password);
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

    ConnectionManager::testConnection();



?>