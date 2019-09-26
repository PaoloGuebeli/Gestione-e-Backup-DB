<?php

require_once ('models/db_manager.php');
require_once ('login.php');

class backup{

    public function home(){
        $alerts = db_manager::getAlerts();
        require('views/backup.php');
    }
}
