<?php

class Contact extends ContactAppModel
{
    
    public $displayField = 'name';
    
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'notEmpty'),
        'email' => array(
            'rule' => 'email',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'email'),
        'message' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'notEmpty'));
}