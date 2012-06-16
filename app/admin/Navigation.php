<?php
namespace admin;

class Navigation {

    function get_list() {
        \Standard::getList('', 'sort ASC');
    }
    
    function get_edit() {
        \Standard::getEdit();
    }
    
    function post_edit() {
        \Standard::postEdit();
    }
    
    function get_add() {
        \Standard::getAdd();
    }
    
    function post_add() {
        \Standard::postAdd();
    }
    
    function get_delete() {
        \Standard::getDelete();
    }
    

}
?>
