<?php

require_once ('models/db_manager.php');

class login
{

    public function index()
    {
        if(isset($_COOKIE['backup_site'])){
            require 'views/home.php';
        }else{
            require 'views/login.php';
        }
    }

    public function check(){
        if(isset($_COOKIE['backup_site'])) {
            $results = db_manager::executeQuery("SELECT * FROM users where pass ='".$_COOKIE['backup_site']."'");
            if ($results !== NULL){
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

    public function admin(){
        $results = db_manager::executeQuery("SELECT * FROM users where pass ='".$_COOKIE['backup_site']."'");
        if($results !== NULL) {
            if ($results[0]['access'] > 1) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function verify()
    {
        if($_POST['email'] != null){
            $results = db_manager::executeQuery("SELECT pass from users where email ='".$_POST['email']."'");
            $hash = $results[0]['pass'];
            if (password_verify($_POST['pass'], $hash)) {
                setcookie('backup_site', $hash, time() + (86400 * 30), "/");
                sleep(3);
                require 'views/home.php';
            } else {
                $_POST['error'] = 'username o password non validi';
                $this->index();
            }
        }
    }
}
