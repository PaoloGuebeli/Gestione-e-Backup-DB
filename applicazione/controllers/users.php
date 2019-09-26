<?php

require_once ('models/db_manager.php');

class users{

    public function home(){
        $users = $this->getUsers();
        $alerts = db_manager::getAlerts();
        require ('views/users.php');
    }

    private function getUsers(){
        return db_manager::executeQuery('SELECT * from users');
    }

    public function addUser(){
        if(isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
            if(db_manager::executeQuery("SELECT * from users where email ='".$_POST['email']."'") == NULL){
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT)."\n";
                db_manager::execute(
                    "INSERT into users (name,lastname,email,pass,access) values ('".$_POST['name']."','".$_POST['lastname']."','".$_POST['email']."','".$hash."',0)"
                    );
                $user = db_manager::executeQuery("SELECT * from users where email ='".$_POST['email']."'");
                db_manager::execute(
                    "INSERT into alerts (content,level,user_id) values ('".$_POST['name']." ".$_POST['lastname']." richiede un account','2','".$user[0]['id']."')"
                );
                $_POST['creationError'] = 'L\'account è stato creato, verrà verificato nei prossimi giorni';
                require('views/login.php');
            }else{
                $_POST['creationError'] = 'Esiste già un account con questa email';
                require('views/login.php');
            }
        }
    }

    public function verify($id){
        db_manager::execute(
            "UPDATE users set access = 1 where id = ".$id
        );
        db_manager::execute(
            "DELETE from alerts where user_id = ".$id
        );
        $this->home();
    }

    public function modify($id){
        if($_POST['mName'] != NULL){
            db_manager::execute(
                "UPDATE users set name = '".$_POST['mName']."' where id = ".$id
            );
        }
        if($_POST['mLastname'] != NULL){
            db_manager::execute(
                "UPDATE users set lastname = '".$_POST['mLastname']."' where id = ".$id
            );
        }
        if($_POST['mEmail'] != NULL){
            db_manager::execute(
                "UPDATE users set email = '".$_POST['mEmail']."' where id = ".$id
            );
        }
        if($_POST['mAccess'] != NULL){
            db_manager::execute(
                "UPDATE users set access = ".$_POST['mAccess']." where id = ".$id
            );
        }
        $this->home();
    }

    public function delete($id){
        db_manager::execute(
            "DELETE from users where id = ".$id
        );
        $this->home();
    }
}
