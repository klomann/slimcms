<?php

namespace admin;

class Panel {
    function get_start() {
        \F3::reroute('/admin/settings/list');
    }
}
?>
