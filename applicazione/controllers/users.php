<?php

require_once('models/db_manager.php');
require_once('models/validate.php');

/**
 * Controllo se l'utente può accedere
 */
if(validate::check()) {

    class users
    {

        /**
         * Questo metodo richiama la pagina degli utenti
         */
        public function home()
        {
            $users = $this->getUsers();
            $alerts = db_manager::getAlerts();
            require('views/users.php');
        }

        /**
         * Questo metdo ritorna l'array di tutti gli utenti
         * @return array|null Ritorna gli utenti se ce ne sono
         */
        private function getUsers()
        {
            /**
             * Ritorno tutti gli utenti
             */
            return db_manager::executeQuery('SELECT * from users');
        }

        /**
         * Questo metodo permette di verificare un account quindi renderlo attivo.
         * @param $id L'id del utente da verificare
         */
        public function verify($id)
        {

            /**
             * Controllo l'id prima di verificare l'account
             */
            if (validate::checkInt($id)) {

                /**
                 * Cambio il livello di accesso del utente da 0 (disattivato) a 1 (responsabile).
                 */
                db_manager::execute(
                    "UPDATE users set access = 1 where id = " . $id
                );

                /**
                 * Elimino la notifica di verifica del utente.
                 */
                db_manager::execute(
                    "DELETE from alerts where user_id = " . $id
                );

            }

            /**
             * Ritorno alla pagina degli utenti
             */
            $this->home();
        }

        /**
         * Questo metodo permette di modificare un utente.
         * @param $id L'id del utente da modificare
         */
        public function modify($id)
        {

            /**
             * Controllo l'id prima di modificare l'account
             */
            if (validate::checkInt($id)) {
                /**
                 * Metto in sicurezza il nome prima di inserirlo nella query
                 */
                $name = validate::secureString($_POST['mName']);
                if ($name != NULL) {
                    db_manager::execute(
                        "UPDATE users set name = '" . $name . "' where id = " . $id
                    );
                }

                /**
                 * Metto in sicurezza il cognome prima di inserirlo nella query
                 */
                $lastname = validate::secureString($_POST['mLastname']);
                if ($lastname != NULL) {
                    db_manager::execute(
                        "UPDATE users set lastname = '" . $lastname . "' where id = " . $id
                    );
                }

                /**
                 * Controllo l'email prima di inserirla nella query
                 */
                if ($_POST['mEmail'] != NULL && validate::checkEmail($_POST['mEmail'])) {
                    db_manager::execute(
                        "UPDATE users set email = '" . $_POST['mEmail'] . "' where id = " . $id
                    );
                }

                /**
                 * Controllo il livello di accesso prima di inserirlo nella query
                 */
                if ($_POST['mAccess'] != NULL && validate::checkInt($_POST['mAccess'])) {
                    db_manager::execute(
                        "UPDATE users set access = " . $_POST['mAccess'] . " where id = " . $id
                    );
                }

            }

            /**
             * Ritorno alla pagina degli utenti
             */
            $this->home();
        }

        /**
         * Questo metodo permette di eliminare un utente.
         * @param $id
         */
        public function delete($id)
        {

            /**
             * Controllo l'id prima di eliminare l'account
             */
            if (validate::checkInt($id)) {

                /**
                 * Elimino l'utente con l'id corrispondente
                 */
                db_manager::execute(
                    "DELETE from users where id = " . $id
                );

                /**
                 * Elimino tutte le notifiche del utente.
                 */
                db_manager::execute(
                    "DELETE from alerts where user_id = " . $id
                );
            }

            /**
             * Ritorno alla pagina degli utenti
             */
            $this->home();
        }
    }
}
