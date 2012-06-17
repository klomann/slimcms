<?php
namespace admin;

class Page {
    function get_list() {
        \Standard::getList();
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
