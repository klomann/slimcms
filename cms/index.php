<?php
require __DIR__ . '/lib/base.php';
F3::set('version', '0.1.2');
F3::set('CACHE', FALSE);
F3::set('DEBUG', 3);
F3::set('UI', 'template/demo/');
F3::set('AUTOLOAD', 'app/');
//F3::set('DB', new DB(
//                'mysql:host=localhost;port=3306;dbname=cms',
//                'root',
//                ''
//        )
//);

F3::set('data', 'db/data.db');
F3::set('DB',new DB('sqlite:{{ @data }}'));
if (!file_exists(F3::get('data'))) {
    Standard::newSQliteDB();
}

F3::route('GET /min', 'Standard->minified');
F3::route('GET /', 'Standard->start');
F3::route('GET /@section/@app/@action/@param', 
        'Standard->load;Standard->routeGet;Standard->display');
F3::route('POST /@section/@app/@action/@param', 
        'Standard->load;Standard->routePost;Standard->display');

F3::route('GET /@section/@app/@action', 
        'Standard->load;Standard->routeGet;Standard->display');
F3::route('POST /@section/@app/@action', 
        'Standard->load;Standard->routePost;Standard->display');


F3::route('GET /sitemap',
	function() {
		Web::sitemap();
	}
);

F3::run();
?>
