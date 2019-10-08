<?php

require_once('models/db_manager.php');
require_once('models/validate.php');

class login
{

	public function index()
	{
		/**
		 * Semplicemente prima di accedere controllo se magari ha già il COOKIE.
		 */
		if (validate::check()) {
			$alerts = db_manager::getAlerts();
			$backups = $this->getBackups();
			$databases = $this->getDatabases();
			require 'views/home.php';
		} else {
			require 'views/login.php';
		}
	}

	/**
	 * Questo metodo verifica il login
	 */
	public function verify()
	{

		/**
		 * Controllo se l'email è valida
		 */
		if (validate::checkEmail($_POST['email'])) {

			/**
			 * Tramite l'email recupero l'hash e controllo se la password corrisponde
			 */
			$results = db_manager::executeQuery("SELECT * from users where email ='" . $_POST['email'] . "'");
			$hash = $results[0]['pass'];

			if (password_verify($_POST['pass'], $hash)) {

				/**
				 * Creo un cookie contenente la password che scadrà dopo 1 ora.
				 */
				setcookie('backup_site', $hash, time() + 3600, "/");

				/**
				 * Se l'utente ha i permessi per accedere lo faccio accedere
				 */
				if ($results[0]['access'] > 0) {

					$first = true;

					if($results[0]['access'] == 2){

						$admin = true;

					}

					$backups = $this->getBackups();
					$databases = $this->getDatabases();
					require 'views/home.php';

				} else {

					$_POST['error'] = 'account non verificato';
					$this->index();

				}

			} else {

				$_POST['error'] = 'email o password non validi';
				$this->index();

			}

		} else {

			$_POST['error'] = 'email o password non validi';
			$this->index();

		}
	}

	/**
	 * Questo metodo permette di fare il logout
	 */
	public function logout()
	{

		/**
		 * Innanzitutto controlla se ha fatto il login
		 */
		if (validate::check()) {

			/**
			 * In seguito disattivo il COOKIE così viene fatto il logout
			 */
			unset($_COOKIE['backup_site']);
			setcookie('backup_site', null, -1, '/');
			$this->index();
		}

	}

	/**
	 * Questo metodo aggiunge un utente al database
	 */
	public function addUser()
	{

		/**
		 * Controllo che tutti i valori sono impostati.
		 */
		if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {

			/**
			 * Rimuovo dalle stringhe tutti i caratteri pericolosi
			 */
			$name = validate::secureString($_POST['name']);
			$lastname = validate::secureString($_POST['lastname']);

			/**
			 * Controllo se l'email è valida
			 */
			if (validate::checkEmail($_POST['email'])) {

				/**
				 * Controllo se l'email è già stata usata
				 */
				if (db_manager::executeQuery("SELECT * from users where email ='" . $_POST['email'] . "'") == NULL) {

					/**
					 * Codifico la password
					 */
					$hash = password_hash($_POST['password'], PASSWORD_DEFAULT) . "\n";

					/**
					 * Inserisco tutti i dati nel database
					 */
					db_manager::execute(
						"INSERT into users (name,lastname,email,pass,access) values ('" . $name . "','" . $lastname . "','" . $_POST['email'] . "','" . $hash . "',0)"
					);

					/**
					 * Controllo se l'utente è stato creato
					 */
					$user = db_manager::executeQuery("SELECT * from users where email ='" . $_POST['email'] . "'");

					/**
					 * Aggiungo la notifica di reichiesta di un account
					 */
					db_manager::execute(
						"INSERT into alerts (content,level,user_id) values ('" . $name . " " . $lastname . " richiede un account','2','" . $user[0]['id'] . "')"
					);

					/**
					 * Ritorno un messaggio di conferma di creazione e ritorno alla pagina di login
					 */
					$msg = "First line of text\nSecond line of text";

					$msg = wordwrap($msg, 70);
					mail($_POST['email'], "Account creates", $msg);
					$_POST['creationError'] = 'L\'account è stato creato, verrà verificato nei prossimi giorni';
					require('views/login.php');
				} else {

					/**
					 * Ritorno un messaggio di feedback e ritorno alla pagina di login
					 */
					$_POST['creationError'] = 'Esiste già un account con questa email';
					require('views/login.php');
				}
			} else {

				/**
				 * Ritorno un messaggio di feedback e ritorno alla pagina di login
				 */
				$_POST['creationError'] = 'Email non valida';
				require('views/login.php');
			}
		}
	}

	public function resetPassword()
	{

	}

	private function getBackups(){
		return db_manager::executeQuery('SELECT * from backup');
	}

	private function getDatabases(){
		return db_manager::executeQuery('SELECT id, name from database_data');
	}
}
