<?php
namespace admin;

class Settings {
    function get_list() {
        \F3::set('site_titel', 'admin');
        \GetHandler::getList('','', 'admin', 0);
    }
    
    function get_edit() {
        \F3::set('site_titel', 'admin');
        \GetHandler::getEdit();
    }
    
    function post_edit() {
        \PostHandler::postEdit();
    }
}
?>
