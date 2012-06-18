<?php
namespace admin;

class Page {
    function get_list() {
        \F3::set('site_titel', 'admin');
        \GetHandler::getList();
    }
    
    function get_edit() {
        \F3::set('site_titel', 'admin');
        \GetHandler::getEdit();
    }
    
    function post_edit() {
        \PostHandler::postEdit();
    }
    
    function get_add() {
        \GetHandler::getAdd();
        
    }
    function post_add() {
        \PostHandler::postAdd();
    }
    
    function get_delete() {
        \GetHandler::getDelete();
    }
    
}
?>
