<?php
class ContactsController extends ContactAppController {
	var $name = 'Contacts';
	var $components = array('Email');

	function beforeFilter() {
		parent::beforeFilter();
		if (isset($this->Auth))
		{
			$this->Auth->allowedActions = array('*');
		}
	}

	/**
	 * You can create a view in app/views/plugins/contacts/contacts/add.ctp
	 * if you need to customize the contact form
	 */
	function add() {
		if ($this->RequestHandler->isGet() && $this->RequestHandler->isAjax()) {
			return $this->render($this->action, 'default', VIEWS . 'contact' . DS . $this->action . '.ctp');
		}
		
		if(!empty($this->data)) {
			$this->Contact->set($this->data);
			if (!$this->Contact->validates()) {
				$this->Session->setFlash(
					__d('contacts', "Please fill-in all required fields", true),
					'message_notice');
					return $this->render($this->action);
			}
	
			if (!$this->Contact->save($this->data, false)) {
				$this->Session->setFlash(
					__d('contacts', "An error occured while saving", true),
					'message_error');
					return $this->render($this->action);
			}
	
			$this->Email->reset();
			if (Configure::read('debug') > 0) {
				$this->Email->delivery = 'debug';
			}
			$this->Email->to = Configure::read('Contact.email');
			$this->Email->from = $this->data['Contact']['email'];
			$this->Email->replyTo = $this->data['Contact']['email'];
			$this->Email->subject = __d('contacts', 'New Contact', true);
			$this->Email->template = 'contact';
			$this->Email->sendAs = 'text';
			$this->set('contact', $this->data);
			$this->Email->send();
	
			$this->Session->setFlash(
				__d('contacts', 'Your message was sent successfully.', true),
				'message_success');
	
			$this->redirect(array('action' => 'thanks'));
		} else {
		  $this->render($this->action);
		}
	}

	/**
	 * Create a app/views/contact/thanks.ctp
	 * to customize your thanks page
	 */
	function thanks() {
		$this->render($this->action);
	}
	
	/**
	 * function render
	 * 
	 */
	
	public function render($action = null, $layout = null, $file = null, $themed = null) {
	  
	  
		if(is_null($action)) $action = $this->action;
		if(is_null($layout)) $layout = 'default';
		
		if (!is_null($themed) && file_exists(VIEWS . 'themed' . DS . $themed . DS . 'contact' . DS . $action . '.ctp')) {
			if(is_null($file)) $file = VIEWS . 'themed' . DS . $themed . DS . 'contact' . DS . $action . '.ctp';
			return parent::render($action, $layout, $file);
		}
		
		if (file_exists(VIEWS . 'contact' . DS . $this->action . '.ctp')) {
		  $file = VIEWS . 'contact' . DS . $this->action . '.ctp';
		}
		return parent::render($action, $layout, $file);
	}
}
?>