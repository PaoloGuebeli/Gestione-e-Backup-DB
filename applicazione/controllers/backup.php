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
			if(validate::checkInt($id)){
				$db_data = db_manager::executeQuery('SELECT * from database_data where id = '.$id);
				$db_data = $db_data[0];
				$now = date('Y-m-d H:i:s');
				$sql_file = $db_data['name'].'_'.date("Y-m-d_H.i.s").'.sql';
				$handle = fopen($sql_file, 'w') or die("Unable to open file!");
				fclose($handle);
				$dir = './backups/'.$sql_file;
				$output = database::dump($db_data['ip'], $db_data['user'], $db_data['pass'], $db_data['name'], $dir);
				if(isset($output[1])) {
					db_manager::execute("Insert into backup (creation_date,status, db_id) values('".$now."','2','')");
					$bc = db_manager::executeQuery("Select id from backup where creation_date ='".$now."'");
					db_manager::execute(
						"INSERT into alerts (content,level,backup_id) values ('Il backup del database" . $db_data['name'] . " è fallito','1','" . $bc[0]['id'] . "')"
					);
				}else{
					db_manager::execute("Insert into backup (creation_date,status, db_id) values('".$now."','1','{$id}')");
				}
				$this->home();
			}
		}

		private function getDatabases(){
        	return db_manager::executeQuery('SELECT id, name, settings_id from database_data');
		}

		private function getSettings(){
			return db_manager::executeQuery('SELECT * from settings');
		}
    }
}
