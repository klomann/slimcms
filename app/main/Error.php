<?php
namespace main;

class Error {

    function get_show() {
        $num = \F3::scrub(\F3::get('PARAMS.param'));
        \F3::set('error_num', $num);
        $arr = $this->errorArray();
        \F3::set('error_text', $arr[$num]);
        \F3::set('template', 'error');
    }
    
    function errorArray() {
        $errorArr = array('zutritt nur f&uuml;r eingeloggte nutzer',
            'diese seite exestiert nicht',
            'diesen blog eintrag gibt es nicht'
        );
        return $errorArr;
    }

}

?>
