<?php
class PostHandler {
    public static function postEdit($model = '') {
        $app = Standard::getApp();
        if ($model == '') {
            $model = $app;
        }
        $obj = Standard::loadByName($model);

        if ($obj->num == 1) {
            $obj->copyFrom('POST');
            $obj->save();
            F3::reroute('/admin/' . $app . '/edit/' . $obj->name);
        } else {
            F3::reroute('/main/error/show/1');
        }
    }

    

    public static function postAdd($model = '') {
        $app = Standard::getApp();
        if ($model == '') {
            $model = $app;
        }
        $obj = new Axon($model);

        $obj->copyFrom('POST');
        $obj->save();
        F3::reroute('/admin/' . $app . '/edit/' . $obj->name);
    }

    

}
?>
