<?php

Router::connect('/', array('controller' => 'generator', 'action' => 'index'));

// Ajax
Router::connect('/ajax/load', array('controller' => 'ajax', 'action' => 'loadData'));
Router::connect('/ajax/preview', array('controller' => 'ajax', 'action' => 'getPreview'));
Router::connect('/ajax/export', array('controller' => 'ajax', 'action' => 'export'));

?>