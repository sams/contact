<?php
App::uses('CakeEmail', 'Utility/Network');
class ContactsController extends ContactAppController {
	var $name = 'Contacts';
	private $_formSender = null;

	public function beforeFilter() {
		parent::beforeFilter();
		if (isset($this->Auth))
		{
			$this->Auth->allowedActions = array('add', 'thanks');
		}
		
		if(!Configure::read('App.defaultEmail') && !Confifure::read('Contact.formSender')) {
			$this->_formSender =  'noreply@' . env('HTTP_HOST');
		} elseif(Configure::read('Contact.formSender')) {
			$this->_formSender =  Configure::read('Contact.formSender');
		} elseif(Configure::read('App.defaultEmail')) {
			$this->_formSender =  Configure::read('App.defaultEmail');
		} else {
			// throw exception cause email aint configured
		}
		
	}

	/**
	 * You can create a view in APP Views/Plugin/contacts/add.ctp
	 * if you need to customize the contact form
	 */
	public function admin_index() {
		$this->Contact->recursive = 0;
		$this->set('messages', $this->paginate());
	}

	/**
	 * You can create a view in APP Views/Plugin/contacts/add.ctp
	 * if you need to customize the contact form
	 */
	public function add() {
		if ($this->request->is('get') && $this->request->is('ajax')) {
			return $this->render($this->action, 'ajax');
		}
		
		if ($this->request->is('post')) {
			$this->Contact->set($this->request->data);
			if (!$this->Contact->validates()) {
				$this->Session->setFlash(
					__d('contacts', "Please fill-in all required fields"),
					'message_notice');
					return $this->render($this->action);
			}
			
			$this->Contact->create();
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been sent'));
			} else {
				$this->Session->setFlash(__('The message could not be sent. Please, try again.'));
			}
	
			if (!$this->Contact->save($this->request->data, false)) {
				$this->Session->setFlash(
					__d('contacts', "An error occured while sending"),
					'message_error');
					return $this->render($this->action);
			}
			
			// http://book.cakephp.org/2.0/en/core-utility-libraries/email.html?highlight=email#CakeEmail
			
			
			// add html?
			// beable to set template?
			$emailCfg = Configure::read('Contact.emailCfg') ? Configure::read('Contact.emailCfg') : 'default';
			
			$email = new CakeEmail($emailCfg);
			$email->from($this->data['Contact']['email'], $this->data['Contact'][$this->Contact->displayField])
			    ->sender($this->_formSender)
			    //->template('welcome', 'fancy')
			    ->emailFormat(Configure::read('Contact.format'))
			    ->replyTo($this->data['Contact']['email'])
			    ->to(Configure::read('Contact.formTo'))
			    ->subject(__d('contacts', 'New Contact'))
			    ->send($this->request->data);
	
			$this->Session->setFlash(
				__d('contacts', 'Your message was sent successfully.'),
				'message_success');
			
			$this->Session->write('Message.email', $this->request->data);
	
			$this->redirect(array('plugin' => 'contact', 'controller' => 'contacts', 'action' => 'thanks'));
		} else {
		  $this->render($this->action);
		}
	}

	/**
	 * Create a app/views/contact/thanks.ctp
	 * to customize your thanks page
	 */
	public function thanks() {
		$this->render($this->action);
	}
	
	/**
	 * function render
	 * 
	 */
	
	public function render($action = null, $layout = null, $file = null, $themed = null) {
	  
	  
		if(is_null($action)) $action = $this->action;
		if(is_null($layout)) $layout = 'default';
		
		if (!is_null($themed) && file_exists(APP . 'View' . DS . 'Themed' . DS . $themed . DS . 'Contact' . DS . $action . '.ctp')) {
			if(is_null($file)) $file = APP . 'View' . DS . 'Themed' . DS . $themed . DS . 'Contact' . DS . $action . '.ctp';
			return parent::render($action, $layout, $file);
		}
		if (file_exists(APP . 'View' . DS . 'Contact' . DS . $this->action . '.ctp')) {
		  $action = APP . 'View' . DS . 'Contact' . DS . $this->action . '.ctp';
		}
		return parent::render($action, $layout);
	}
}
?>