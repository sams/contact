<?php echo $this->element('contact', array('plugin' => null)); ?>
<?php 
$this->Html->css('/contacts/css/contacts.css', null, array('inline' => false)); ?>
<h2><?php echo $this->pageTitle = __d('contact', 'Contact') ?></h2>
<?php
echo $this->Form->create('Contact', array('class' => 'form-stacked'));
echo $this->Form->input('name', array(
    'label' => 'Name',
    'error' => array(
        'notEmpty' => __d('contact', 'Please specify your name'))));
echo $this->Form->input('address', array('label' => 'Adress'));
echo $this->Form->input('zip', array('label' => ' Zip Code'));
echo $this->Form->input('city', array('label' => 'City'));
echo $this->Form->input('country', array('label' => 'State'));
echo $this->Form->input('phone', array('label' => 'Telephone'));
echo $this->Form->input('email', array(
    'label' => 'Email',
    'error' => array(
        'email' => __d('contact', 'Please specify your email'))));
echo $this->Form->input('message', array(
    'label' => 'Message',
    'error' => array(
        'notEmpty' => __d('contact', 'Please specify your message'))));
echo $this->Form->submit(__d('contact', 'Submit'));
?>