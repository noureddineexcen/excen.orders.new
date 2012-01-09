<?php
/**
 * Deze controller handelt requests af in de admin module
 *
  */
class Admin_AuthenticationController extends Zend_Controller_Action
{
//	protected $_module;
//	protected $_controller;
//	protected $_action;
	protected $_role;
//
    /**
     * init wordt automatisch uitgevoerd door het dispatch proces
     */
	public function init()
	{
//		$request = $this->getRequest();
//		$this->_module = $request->getModuleName();
//		$this->_controller = $request->getControllerName();
//		$this->_action = $request->getActionName();
		$this->_role = Site_Model_Authentication::getInstance()->getUser()->getRole();
	}

	/**
	 * index toont het inlogscherm
	 * @return void
	 */
	public function indexAction() {
		$this->_forward('login');
	}

	/**
	 */
	public function loginAction() {
		// eerst controleren of we mogen inloggen
		$request = $this->getRequest();
			$loginForm = new Admin_Form_Authentication_Login();

			$this->view->form = $loginForm;

			// we zetten de action van het form op de huidige URL
			$loginForm->setAction($this->view->url());
                        var_dump('ddd');
			if ($request->isPost()) {
				// Formulier valideren
				if ($loginForm->isValid($request->getPost())) {
					$username = $loginForm->getElement('username')->getValue();
					$password = $loginForm->getElement('password')->getValue();
					$auth = Site_Model_Authentication::getInstance();
                                                                var_dump('ddd');

					if (Zend_Auth_Result::SUCCESS == $auth->login($username, $password)) {
                                                                    var_dump('ddd');

						//$redirect = $loginForm->getElement('redirect')->getValue();
						//if (strlen($redirect) > 0) {
							// redirect links zijn gecodeerd zodat ze geen probleem voor de router opleveren
							//$link = base64_decode($redirect);
							//$this->_redirect($link);
						//} else {
							// naar admin home
							$this->getHelper('Redirector')->gotoSimple('index', 'index', 'admin');
						//}
					} else {
						// toon foutmelding
						$this->view->failed = true;
					}
				} else {
					// toon foutmelding
					$this->view->failed = true;
				}
			} else {
				// toon het inlog form. Zet de redirect waarde in het formulier
				// redirect wordt meegegeven als een hash-waarde
				//$loginForm->getElement('redirect')->setValue($request->getParam('redirect', ''));
			}
//		} else {
//			// gebruiker mag niet inloggen
//			$this->_forward('not-allowed', 'authentication', 'admin');
//			//$this->getHelper('Redirector')->gotoSimple('not-allowed', 'authentication', 'admin');
//		}
	}

	/**
	 */
	public function logoutAction() {
		Site_Model_Authentication::getInstance()->logout();
		$this->_redirect('/');
	}

	/**
	 * toon een pagina met de waarschuwing dat de gebruiker geen rechten heeft om de informatie te zien
	 */
	public function notAllowedAction() {
		$this->view->link = $this->view->url(array('module' => 'default', 'controller' => 'blogpost', 'action' => 'index'));
	}
}