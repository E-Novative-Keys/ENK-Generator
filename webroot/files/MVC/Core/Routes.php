<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'index'));

Router::connect('/about', array('controller' => 'about', 'action' => 'index'));
Router::connect('/contact', array('controller' => 'contact', 'action' => 'index'));

Router::connect('/login', array('controller' => 'admin', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'admin', 'action' => 'logout'));

Router::connect('/admin', array('controller' => 'admin', 'action' => 'index'));

Router::connect('/admin/about', array('controller' => 'about', 'action' => 'addAdmin'));

Router::connect('/admin/users', array('controller' => 'admin', 'action' => 'listUsers'));
Router::connect('/admin/add-user', array('controller' => 'admin', 'action' => 'addUser'));

Router::connect('/admin/team', array('controller' => 'team', 'action' => 'listAdmin'));
Router::connect('/admin/add-team', array('controller' => 'team', 'action' => 'addAdmin'));

Router::connect('/admin/testimonials', array('controller' => 'testimonials', 'action' => 'listAdmin'));
Router::connect('/admin/add-testimonial', array('controller' => 'testimonials', 'action' => 'addAdmin'));

Router::connect('/admin/clients', array('controller' => 'clients', 'action' => 'listAdmin'));
Router::connect('/admin/add-client', array('controller' => 'clients', 'action' => 'addAdmin'));

Router::connect('/admin/newsletter', array('controller' => 'newsletter', 'action' => 'sendAdmin'));

Router::connect('/admin/delete/:model/:id',
	array('controller' => 'admin', 'action' => 'delete'),
	array('model' => '[a-zA-Z]+', 'id' => '[0-9]+')
);

?>