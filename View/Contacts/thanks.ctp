<p>Thanks</p>
<?php
$this->Html->css('/contacts/css/contacts.css', null, array('inline' => false));
if (Configure::read('debug') > 0):
    debug(Configure::read('Contact'));
    debug($this->Session->read('Message.email'));
endif;