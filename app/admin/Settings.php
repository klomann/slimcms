<?php
namespace admin;

class Settings {
    function get_list() {
        \Standard::getList();
    }
    
    function get_edit() {
        \Standard::getEdit();
    }
    
    function post_edit() {
        \Standard::postEdit();
    }
}
?>
