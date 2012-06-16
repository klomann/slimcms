<?php

namespace main;

class Page {

    function get_show() {
        $page = \main\Page::loadPage();
        if ($page->num == 1) {
            \F3::set('template', 'page');
            \F3::set('page_titel', $page->title);
            \F3::set('page_content', $page->content);
        } else {
            \F3::reroute('/main/error/show/1');
        }
    }

    static function loadPage() {
        $page = new \Axon('page');
        $page->def('num', 'COUNT(name)');
        $name = \F3::scrub(\F3::get('PARAMS.param'));
        $page->load(array('name=:name', array(':name' => $name)));
        return $page;
    }
}

?>
