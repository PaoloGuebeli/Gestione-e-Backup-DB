<?php

require_once ('models/db_manager.php');
require_once ('models/validate.php');
/**
 * Controllo se l'utente può accedere
 */
if(validate::check()) {

    class backup
    {

        public function home()
        {
        	$databases = $this->getDatabases();
        	$settings = $this->getSettings();
            $alerts = db_manager::getAlerts();
            require('views/backup.php');
        }

		public function startBackup($id){

		}

		private function getDatabases(){
        	return db_manager::executeQuery('SELECT name, settings_id from database_data');
		}

		private function getSettings(){
			return db_manager::executeQuery('SELECT * from settings');
		}
    }
}
