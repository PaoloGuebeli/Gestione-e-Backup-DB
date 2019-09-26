<?php

require_once ('models/db_manager.php');

class login
{

    public function index()
    {
        if($this->check()){
            $alerts = db_manager::getAlerts();
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
        if(isset($_COOKIE['backup_site'])) {
            $results = db_manager::executeQuery("SELECT * FROM users where pass ='" . $_COOKIE['backup_site'] . "'");
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

    public function verify()
    {
        if($_POST['email'] != null){
            $results = db_manager::executeQuery("SELECT * from users where email ='".$_POST['email']."'");
            $hash = $results[0]['pass'];
            if (password_verify($_POST['pass'], $hash)) {
                setcookie('backup_site', $hash, time() + (86400 * 30), "/");
                if($results[0]['access'] > 0) {
                    $first = true;
                    require 'views/home.php';
                }else{

                    $_POST['error'] = 'account non verificato';
                    $this->index();
                }
            } else {
                $_POST['error'] = 'username o password non validi';
                $this->index();
            }
        }
    }

    public function logout(){
        unset($_COOKIE['backup_site']);
        setcookie('backup_site', null, -1, '/');
        $this->index();
    }
}
