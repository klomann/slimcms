<?php
require __DIR__ . '/lib/base.php';

F3::set('CACHE', FALSE);
F3::set('DEBUG', 3);
F3::set('UI', 'template/');
F3::set('AUTOLOAD', 'app/');
F3::set('DB', new DB(
                'mysql:host=localhost;port=3306;dbname=cms',
                'root',
                ''
        )
);
F3::route('GET /min', 'Standard->minified');
F3::route('GET /', 'Standard->start');
F3::route('GET /@section/@controller/@action/@param', 
        'Standard->load;Standard->routeGet;Standard->display');
F3::route('POST /@section/@controller/@action/@param', 
        'Standard->load;Standard->routePost;Standard->display');

F3::route('GET /@section/@controller/@action', 
        'Standard->load;Standard->routeGet;Standard->display');
F3::route('POST /@section/@controller/@action', 
        'Standard->load;Standard->routePost;Standard->display');

F3::run();
?>
