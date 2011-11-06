<?php


// CakePlugin::loadAll(array('Contact' => array('bootstrap' => true, 'routes' => true)));
Configure::write('Contact.formTo', 'webmaster@' . env('HTTP_HOST'));
Configure::write('Contact.emailCfg', 'default');
Configure::write('Contact.format', 'html');