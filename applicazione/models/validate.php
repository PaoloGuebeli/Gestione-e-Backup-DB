<?php

class validate{

	/**
	 * Questo metodo controlla se l'email passata è valida
	 * @param $email String Email da controllare
	 * @return bool Email valida
	 */
    public static function checkEmail($email){
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

	/**
	 * Questo metodo mette in sicurezza la stringa passata
	 * @param $string String Sringa da mettere in sicurezza
	 * @return mixed Stringa sicura
	 */
    public static function secureString($string){
        return filter_var($string, FILTER_SANITIZE_STRIPPED);
    }

	/**
	 * Questo metodo controlla se il valore passato è un int
	 * @param $int String Valore da controllare
	 * @return bool È un int
	 */
    public static function  checkInt($int){
        if(filter_var($int, FILTER_VALIDATE_INT)){
            return true;
        }
        return false;
    }

    /**
     * Questa funzione controlla se l'utente possiede un cookie valido
     * @return bool $
     */
    public static function check(){

        /**
         * Controllo se inanzitutto possiede un cookie
         */
        if(isset($_COOKIE['backup_site'])) {
            /**
             * Metto in sicurezza la stringa del cookie e controllo se è valido
             */
            $backup_site = validate::secureString($_COOKIE['backup_site']);
            $results = db_manager::executeQuery("SELECT * FROM users where pass ='".$backup_site."'");
            if ($results !== NULL){

                /**
                 * Controllo se ha un livello di accesso sufficiente per accedere
                 */
                if($results[0]['access'] > 0){
                    return true;
                }else{
                    $_POST['error'] = 'account non verificato';
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

	/**
	 * Questo metodo ritorna true se l'utente collegato è un amministratore
	 * @return bool È un amministratore
	 */
    public static function admin(){

		/**
		 * Controllo se c'è qualcuno collegato
		 */
        if(isset($_COOKIE['backup_site'])) {

			/**
			 * Prendo i dati del utente collegato
			 */
            $results = db_manager::executeQuery("SELECT * FROM users where pass ='" . $_COOKIE['backup_site'] . "'");

			/**
			 * Se l'utente è presente nel database controlla il suo livello d'accesso
			 */
            if ($results !== NULL) {
                if ($results[0]['access'] > 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}