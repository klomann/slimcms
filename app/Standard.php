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
        $controller = F3::scrub(F3::get('PARAMS.controller'));
        $action = F3::scrub(F3::get('PARAMS.action'));
        $login = F3::get('SESSION.login');
        if ($section == 'admin' && $login != 1) {
            F3::reroute('/main/error/show/0');
        } else {
            if ($section == 'admin') {
                F3::set('template', 'admin');
            }
            F3::call($section . '\\' . $controller . '->' . $kind . '_' . $action);
        }
    }

    function minified() {
        if (isset($_GET['base']) && isset($_GET['files'])) {
            $_GET = F3::scrub($_GET);
            Web::minify($_GET['base'], explode(',', $_GET['files']));
        }
    }

    static function loadByName($table) {
        $obj = new \Axon($table);
        $obj->def('num', 'COUNT(name)');
        $name = F3::scrub(F3::get('PARAMS.param'));
        $obj->load(array('name=:name', array(':name' => $name)));
        return $obj;
    }

    static function getEdit($model = '') {
        $controller = self::getController();
        if ($model == '') {
            $model = $controller;
        }
        $obj = self::loadByName($model);

        if ($obj->num == 1) {
            $obj->copyTo('POST');
            F3::set('action', '{{@BASE}}/admin/' . $controller . '/edit/{{@PARAMS.param}}');
            F3::set('edit', 1);
            F3::set('controller', $controller);
            F3::set('admin_template', 'edit');
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    static function postEdit($model = '') {
        $controller = self::getController();
        if ($model == '') {
            $model = $controller;
        }
        $obj = self::loadByName($model);

        if ($obj->num == 1) {
            $obj->copyFrom('POST');
            $obj->save();
            F3::reroute('/admin/' . $controller . '/edit/' . $obj->name);
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    static function getAdd() {
        $controller = self::getController();
        F3::set('edit', 0);
        F3::set('action', '{{@BASE}}/admin/' . $controller . '/add');
        F3::set('controller', $controller);
        F3::set('admin_template', 'edit');
    }

    static function postAdd($model = '') {
        $controller = self::getController();
        if ($model == '') {
            $model = $controller;
        }
        $obj = new Axon($model);

        $obj->copyFrom('POST');
        $obj->save();
        F3::reroute('/admin/' . $controller . '/edit/' . $obj->name);
    }

    static function getList($model = '', $order = '', $section = 'admin', $add = 1) {
        $controller = self::getController();
        if ($model == '') {
            $model = $controller;
        }
        $obj = new Axon($model);
        $list = $obj->afind('', $order);
        F3::set('list', $list);
        F3::set('add', $add);
        F3::set('controller', $controller);
        F3::set($section . '_template', 'list');
    }

    static function getDelete($model = '') {
        $controller = self::getController();
        if ($model == '') {
            $model = $controller;
        }
        $obj = self::loadByName($model);
        if ($obj->num == 1) {
            $obj->erase();
            F3::reroute('/admin/' . $controller . '/list');
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    static function getShow($model = '') {
        $controller = self::getController();
        if ($model == '') {
            $model = $controller;
        }
        $obj = self::loadByName($model);
        if ($obj->num == 1) {
            F3::set('template', $controller);
            $obj->copyTo('MODEL');
        } else {
            F3::reroute('/main/error/show/1');
        }
    }
    static function getController() {
        return F3::scrub(F3::get('PARAMS.controller'));
    }

    static function newSQliteDB() {
        DB::sql(array('CREATE TABLE navigation (
                        name TEXT,
                        text TEXT,
                        section TEXT,
                        controller TEXT,
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
