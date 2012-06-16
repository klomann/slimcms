<?php

namespace main;

class User {

    function get_login() {
        \F3::clear('SESSION');
        \F3::set('SESSION.login', 0);
        \F3::set('template', 'login');
    }

    function get_logout() {
        \F3::clear('SESSION');
        \F3::reroute('/main/user/login');
    }
    function post_login() {
        \F3::clear('message');
        $this->checkUsername();
        $this->checkPw();
        $username = \F3::scrub($_POST['username']);
        $pw = \F3::scrub($_POST['pw']);
        $user = new \Axon('user');
        $user->def('num','COUNT(id)');
        $user->load(array('username=:username AND pw=:pw', 
            array(':username' => $username, ':pw' => md5($pw))));
        if ($user->num == 1) {
            \F3::set('SESSION.username', $user->username);
            \F3::set('SESSION.login', 1);
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
            \F3::set('message', 'login ok');
            \F3::reroute('/admin/panel/start');
        } else {
            \F3::set('message', 'falsche login daten');
            $this->get_login();
        }
        
    }

    function checkUsername() {
        \F3::input('username', function($value) {
                    if(!\F3::exists('message')) {
                        if (empty($value)) {
                            \F3::set('message', 'der username ist leer');
                        }
                    }
                });
    }

    function checkPw() {
        \F3::input('pw', function($value) {
                    if(!\F3::exists('message')) {
                        if (empty($value)) {
                            \F3::set('message', 'das passwort ist leer');
                        }
                    }
                });
    }
    

}

?>
