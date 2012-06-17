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
        \F3::set('SESSION.login', 0);
        \F3::reroute('/main/user/login');
    }
    function post_login() {
        \F3::clear('message');
        $this->checkInput('name');
        $this->checkInput('pw');
        $name = \F3::get('POST.name');
        $pw = \F3::get('POST.pw');
        $name = \F3::scrub($name);
        $pw = \F3::scrub($pw);
        $user = new \Axon('user');
        $user->def('num','COUNT(name)');
        $user->load(array('name=:name AND pw=:pw', 
            array(':name' => $name, ':pw' => md5($pw))));
        if ($user->num == 1) {
            \F3::set('SESSION.name', $user->name);
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

    
    function checkInput($input) {
        \F3::input($input, function($value) {
                    if(!\F3::exists('message')) {
                        if (empty($value)) {
                            \F3::set('message', 'das '. $input .' feld ist leer');
                        }
                    }
                });
    }

}

?>
