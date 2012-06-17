<?php
namespace main;

class Error {

    function get_show() {
        $num = (int)\F3::scrub(\F3::get('PARAMS.param'));
        \F3::set('error_num', $num);
        $arr = $this->errorArray();
        
        \F3::set('error_text', $arr[$num]);
        \F3::set('template', 'error');
    }
    
    function errorArray() {
        $errorArr = array('auth error',
            'not found',
        );
        return $errorArr;
    }

}

?>
