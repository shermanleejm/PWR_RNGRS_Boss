<?php

class ConnectionManager {
    public function getConnection() {
        $credentials = parse_ini_file( ($_SERVER["DOCUMENT_ROOT"] . "/../private/database.ini") ) ;
        
        $conn = mysqli_connect($credentials["host"], $credentials["username"], $credentials["password"], $credentials["dbname"]);

        return $conn;
    }
}

// $dao = new ConnectionManager();
// $pdo = $dao->getConnection();
// $sql = "DELETE table table1";
// $stmt = $pdo->prepare($sql);
// $stmt->execute();

?>