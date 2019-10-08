<?php

require_once('database.php');

class db_manager
{

    public static function executeQuery($query)
    {
        $conn = database::getConnection();
        $results = array();
        $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($results, $row);
                }
            } else {
                return NULL;
            }
        return $results;
    }

    public static function execute($query){
        $conn = database::getConnection();
        $conn->query($query);
    }

    public static function getAlerts(){
        $results = db_manager::executeQuery("SELECT * FROM users where pass ='".$_COOKIE['backup_site']."'");
        $alerts = db_manager::executeQuery("SELECT * FROM alerts where level <=".$results[0]['access']);
        return $alerts;
    }
}
