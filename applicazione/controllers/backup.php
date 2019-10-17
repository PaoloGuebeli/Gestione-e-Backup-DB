<?php

require_once('models/db_manager.php');
require_once('models/validate.php');
/**
 * Controllo se l'utente può accedere
 */
if (validate::check()) {

	class backup
	{

		public function home()
		{
			$databases = $this->getDatabases();
			$settings = $this->getSettings();
			$alerts = db_manager::getAlerts();
			require('views/backup.php');
		}

		/**
		 * Questa funzione crea il backup del database passato.
		 * @param $id int Id del database
		 */
		public function startBackup($id)
		{

			/**
			 * Controllo se l'id è un int.
			 */
			if (validate::checkInt($id)) {

				/**
				 * Prendo le informazioni del database di cui devo fare il backup.
				 */
				$db_data = db_manager::executeQuery('SELECT * from database_data where id = ' . $id);
				if (isset($db_data[0]) || $db_data[0] != NULL) {
					$db_data = $db_data[0];

					/**
					 * Salvo la data dell'esecuzione.
					 */
					$now = date('Y-m-d H:i:s');
					$sql_file = $db_data['name'] . '_' . date("Y-m-d_H.i") . '.sql';
					$dir = './backups/' . $sql_file;

					/**
					 * Controllo se il file esiste già.
					 */
					if (!file_exists($dir)) {

						/**
						 * Creo il file sql.
						 */
						$handle = fopen($dir, 'w') or die("Unable to open file!");
						fclose($handle);

						/**
						 * Faccio il dump del database
						 */
						$output = database::dump($db_data['ip'], $db_data['user'], $db_data['pass'], $db_data['name'], $dir);
						if (isset($output[1])) {

							/**
							 * Se va male inserisco il backup come fallito. E aggiungo la notifica.
							 */
							db_manager::execute("Insert into backup (creation_date,status, db_id) values('" . $now . "','2','')");
							$bc = db_manager::executeQuery("Select id from backup where creation_date ='" . $now . "'");
							db_manager::execute(
								"INSERT into alerts (content,level,backup_id) values ('Il backup del database" . $db_data['name'] . " è fallito','1','" . $bc[0]['id'] . "')"
							);
						} else {

							/**
							 * Se tutto va bene inserisco il backup come successo.
							 */
							db_manager::execute("Insert into backup (creation_date,status, db_id) values('" . $now . "','1','{$id}')");
						}
					}

					/**
					 * Richiamo la pagina di backup.
					 */
					$this->home();
				}
			}
		}

		/**
		 * Questo metodo serve al cron job per avviare i backup programmati
		 */
		public function checkForBackups(){

			/**
			 * Controllo se esistono delle impostazioni che iniziano a qiest'ora
			 */
			$sets = $this->getSettings();

			foreach ($sets as $set) {
				if($set['day'] == date('w')){
					if($set['hour'] == date('H')){

						/**
						 * Se esistono prendo tutti i db che hanno queste impostazioni
						 */
						$dbs = db_manager::executeQuery("Select id from database_data where settings_id = {$set['id']}");

						/**
						 * Avvio tutti i backup
						 */
						foreach ($dbs as $db) {
							$this->startBackup($db['id']);
						}
					}
				}
			}
		}

		private function getDatabases()
		{
			return db_manager::executeQuery('SELECT id, name, settings_id from database_data');
		}

		private function getSettings()
		{
			return db_manager::executeQuery('SELECT * from settings');
		}
	}
}
