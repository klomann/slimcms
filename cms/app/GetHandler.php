<?php

class GetHandler {

    public static function getAdd() {
        $app = Standard::getApp();
        F3::set('edit', 0);
        F3::set('action', '{{@BASE}}/admin/' . $app . '/add');
        F3::set('app', $app);
        F3::set('admin_template', 'edit');
    }

    public static function getList($model = '', $order = '', $section = 'admin', $add = 1) {
        $app = Standard::getApp();
        if ($model == '') {
            $model = $app;
        }
        $obj = new Axon($model);
        $list = $obj->afind('', $order);
        F3::set('list', $list);
        F3::set('add', $add);
        F3::set('app', $app);
        F3::set($section . '_template', 'list');
    }

    public static function getDelete($model = '') {
        $app = Standard::getApp();
        if ($model == '') {
            $model = $app;
        }
        $obj = Standard::loadByName($model);
        if ($obj->num == 1) {
            $obj->erase();
            F3::reroute('/admin/' . $app . '/list');
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    public static function getShow($model = '') {
        $app = Standard::getApp();
        if ($model == '') {
            $model = $app;
        }
        $obj = Standard::loadByName($model);
        if ($obj->num == 1) {
            F3::set('site_titel', $obj->titel);
            F3::set('template', $app);
            $obj->copyTo('MODEL');
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    public static function getEdit($model = '') {
        $app = Standard::getApp();
        if ($model == '') {
            $model = $app;
        }
        $obj = Standard::loadByName($model);

        if ($obj->num == 1) {
            $obj->copyTo('POST');
            F3::set('action', '{{@BASE}}/admin/' . $app . '/edit/{{@PARAMS.param}}');
            F3::set('edit', 1);
            F3::set('app', $app);
            F3::set('admin_template', 'edit');
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

}

?>
