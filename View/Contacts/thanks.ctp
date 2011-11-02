<?php echo $this->element('contact', array('plugin' => null)); ?>
<?php
$this->Html->css('/contacts/css/contacts.css', null, array('inline' => false));
if (Configure::read('debug') > 0):
    debug($this->Session->read('Message.email'));
endif;