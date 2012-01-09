<?php
/**
 * Authentication
 * Deze klasse regelt de identificatie van een gebruiker. Het implementeert het singleton patroon
 *
 */
class Site_Model_Authentication {
	const DEFAULT_ROLE = 'guest';

	protected static $_instance = null;

	private $_user;
	private $_auth;
	private $_loggedIn;

	/**
	 * singleton implementatie voor eenvoudige toegang naar de ingelogde gebruiker
	 * @return Site_Model_Authentication
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	/**
	 * controleer of er een ingelogde gebruiker is, zo ja
	 * creeer een User-object met de gegevens van de gebruiker
	 *
	 */
	protected function __construct() {
		$this->_user = new Site_Model_User();
		$this->_auth = Zend_Auth::getInstance();
		if ($this->_auth->hasIdentity()) {
			$result = $this->_user->loadByUserName($this->_auth->getIdentity());
 			if (null != $result) {
				$this->_loggedIn = true;
			} else {
				// ingelogde gebruiker bestaat niet in de database, verwijder login gegevens
				$this->logout();
			}
		} else {
                    
			$this->_loggedIn = false;
		}
	}

	/**
	 * Deze methode voert de loginactie uit. Als de login is gelukt, wordt de bijbehorende
	 * User gelezen uit de database en bewaart binnen het Authenticate-object
	 * @param string $username
	 * @param string $password
	 * @return int Zend_Auth_Result constante
	 */
	public function login($username, $password) {
		try {
			$this->_loggedIn = false;
			$result = Zend_Auth_Result::FAILURE;
			if ((is_string($username) && (strlen($username) > 0)) &&
				(is_string($password) && (strlen($password) > 0))) {
				$authAdapter = $this->_createAuthenticationAdapter($username, $password);
				$authResult = $this->_auth->authenticate($authAdapter);
				if ($authResult->isValid()) {
                                     $user = $authAdapter->getResultRowObject(array('username', 'firstname', 'lastname', 'role_id'));
                                     //$oRole = new Site_Model_Role();

                                     //$aRole = $oRole->getRoleName(1);
                                     //var_dump($aRole);exit;
                                     $this->_auth->getStorage()->write($user);
				     $this->_loggedIn = true;
				} else {
					Zend_Registry::get('logger')->info(__METHOD__. ' - authentication failed: '.print_r($authResult->getMessages(), true));
				}
				$result = $authResult->getCode();
			}
		} catch (Exception $e) {
			Zend_Registry::get('logger')->info(__METHOD__. ' exception in login '.$e->getMessage());
			$this->_loggedIn = false;
			// clear any logged in users
			$this->logout();
			throw $e;
		}
		return $result;
	}

	public function logout() {
		$this->_loggedIn = false;
		if ($this->_auth == null) {
			$this->_auth = Zend_Auth::getInstance();
		}
		$this->_auth->clearIdentity();
		$this->_user = new Site_Model_User();
	}

	public function isLoggedIn() {
		return $this->_loggedIn;
	}

	/**
	 * retourneer de huidige gebruiker
	 * @return Site_Model_User
	 */
	public function getUser() {
		return $this->_user;
	}
	
	/**
	 * creeer een authentication adapter object
	 * Het authentication object gebruikt SHA1 encryptie methode om wachtwoorden te versleutelen
	 * Wachtwoorden worden altijd geprefixt met een SALT om de wachtwoorden complexer te maken
	 *
	 * @param string $username de login naam
	 * @param string $password ongecrypte wachtwoord
	 * @return Zend_Auth_Adapter_DbTable De gevraagde authentication adapter
	 */
	private function _createAuthenticationAdapter($username, $password) {
                $db = Zend_Db_Table::getDefaultAdapter();
		$adapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password', 'SHA1(?)');
		// voeg een geheime string toe aan het wachtwoord voor betere beveiliging
		$saltedPassword = Site_Model_User::SALT . $password;
		$adapter->setIdentity($username);
		$adapter->setCredential($saltedPassword);
		return $adapter;
	}


}
