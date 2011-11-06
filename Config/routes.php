<?php



/**
 * Contact
 */

Router::connect('/contact', array('plugin' => 'contact', 'controller' => 'contacts', 'action' => 'add'));
Router::connect('/contact/thanks', array('plugin' => 'contact', 'controller' => 'contacts', 'action' => 'thanks'));
Router::connect('/admin/contacts', array('plugin' => 'contact', 'admin' => true, 'prefix' => 'admin', 'controller' => 'contacts', 'action' => 'index'));
Router::connect('/admin/contacts/:action/*', array('plugin' => 'contact', 'admin' => true, 'prefix' => 'admin', 'controller' => 'contacts'));

/*^*/