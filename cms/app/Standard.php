<?php

class Standard {

    function load() {
        $settings = new Axon('settings');
        $settings->load('name="titel"');
        F3::set('system_titel', $settings->value);
        $navigation = new Axon('navigation');
        $list = $navigation->afind('', 'sort ASC');
        F3::set('navigation', $list);
    }

    function display() {

        $session = F3::get('SESSION.login');
        F3::set('debug', $session);
        echo Template::serve('site.html');
    }

    function start() {
        F3::reroute('/main/page/show/start');
    }

    function routeGet() {
        $this->route('get');
    }

    function routePost() {
        $this->route('post');
    }

    function route($kind) {
        $section = F3::scrub(F3::get('PARAMS.section'));
        $app = F3::scrub(F3::get('PARAMS.app'));
        $action = F3::scrub(F3::get('PARAMS.action'));
        if ($section == 'admin' || $section == 'main') {
            
        
        $login = F3::get('SESSION.login');
        if ($section == 'admin' && $login != 1) {
            F3::reroute('/main/error/show/0');
        } else {
            if ($section == 'admin') {
                F3::set('template', 'admin');
            }
            F3::call($section . '\\' . $app . '->' . $kind . '_' . $action);
        }
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    function minified() {
        if (isset($_GET['base']) && isset($_GET['files'])) {
            $_GET = F3::scrub($_GET);
            Web::minify($_GET['base'], explode(',', $_GET['files']));
        }
    }

    static function loadByName($table) {
        $obj = new Axon($table);
        $obj->def('num', 'COUNT(name)');
        $name = F3::scrub(F3::get('PARAMS.param'));
        $obj->load(array('name=:name', array(':name' => $name)));
        return $obj;
    }
    
    static function getApp() {
        return F3::scrub(F3::get('PARAMS.app'));
    }

    static function newSQliteDB() {
        DB::sql(array('CREATE TABLE navigation (
                        name TEXT,
                        text TEXT,
                        section TEXT,
                        app TEXT,
                        action TEXT,
                        target TEXT,
                        sort TEXT,
                        PRIMARY KEY (name)
                        );',
                        'CREATE TABLE page (
                        name TEXT,
                        titel TEXT,
                        content TEXT,
                        PRIMARY KEY (name)
                        );',
                        'CREATE TABLE settings (
                        name TEXT,
                        value TEXT,
                        PRIMARY KEY (name)
                        );',
                        'CREATE TABLE user (
                        name TEXT,
                        pw TEXT,
                        last_login TEXT,
                        PRIMARY KEY (name)
                        );',
                        "INSERT INTO user VALUES('admin','". md5('admin') ."','');",
                        "INSERT INTO settings VALUES('titel', 'cms tutorial');",
                        "INSERT INTO page VALUES('hello_world','HELLO','WORLD');",
                        "INSERT INTO navigation VALUES('start','test','main','page','show','hello_world','0');"
                        ));
    }
}

?>
