<?php

require_once ('database.php');

class db_manager{

    public static function executeQuery($query){
        $conn = database::getConnection();
        $results = array();
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($results, $row);
            }
        }else{
            return NULL;
        }
        return $results;
    }
}
