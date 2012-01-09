<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	 * initialiseer de autoloader zodat alle klassen worden gevonden die
	 * voldoen aan de Zend Framework naamgevingsconventie en
	 * in het include pad voorkomen
	 * @return void
	 */
	protected function _initAutoloader()
	{
		// namespace '' voegen we toe zodat we voor onze model classes geen modulenaam in de prefix hoeven op te nemen
		// helaas kunnen we geen lege namespace in application.ini plaatsen
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Site_',
			'basePath' => APPLICATION_PATH,
		));
	}

        protected function _initNavigation()
        {
            $this->bootstrap('layout');
            $layout = $this->getResource('layout');
            $view = $layout->getView();
            $config = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml','nav');
            $navigation = new Zend_Navigation($config);
            $view->navigation($navigation);
        }

	/**
	 * Initialiseer het View-object met de gegevens in de resources.view uit de application.ini
	 * @return void
	 *
	protected function _initHtml()
	{
		// we bootstrappen de view. Dit is een dependency.
		// Als hij al gebootstrapt is gebeurt er niks
		$this->bootstrap('view');
		$view = $this->getResource('view');

		// haal de opties uit application.ini op
		$options = $this->getOptions();
		if (isset($options['resources']['view']['doctype'])) {
			$view->doctype($options['resources']['view']['doctype']);
		}
		if (isset($options['resources']['view']['encoding'])) {
			$view->setEncoding($options['resources']['view']['encoding']);
		}
		if (isset($options['resources']['view']['contentType'])) {
			$view->headMeta()->appendHttpEquiv('Content-Type',
				$options['resources']['view']['contentType']);
		}
		if (isset($options['resources']['view']['keywords'])) {
			$view->headMeta()->appendName('keywords', $options['resources']['view']['keywords']);
		}
	}
        */
	/**
	 * initialiseer de CSS-stylesheets
	 * @return void
	 */
	protected function _initCss()
	{
		// we bootstrappen de view. Dit is een dependency.
		// Als hij al gebootstrapt is gebeurt er niks
		$this->bootstrap('view');
		// We halen de view uit de bootstrap container. Is hetzelfde object als in de viewrenderer
		$view = $this->getResource('view');
		// voeg de stylesheet toe aan de view resource
		$view->headLink()->appendStylesheet('/css/style.css');
	}

    /**
     * initialiseer de Javascript bestanden
     * @return void
     *
    protected function _initJavascript()
    {
        // we bootstrappen de view. Dit is een dependency.
        // Als hij al gebootstrapt is gebeurt er niks
        $this->bootstrap('view');

        // We halen de view uit de bootstrap container.
        // Is hetzelfde object als in de viewrenderer
        $view = $this->getResource('view');

        // voeg de JQuery javascript toe aan de view resource
        $view->headScript()->appendFile(
            'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'
        );

        // en ons eigen javascript bestand:
        $this->view->headScript()->appendFile('/js/weblog.js');

    }*/

	/**
	 * We willen de database vanuit onze model-klassen eenvoudig kunnen
	 * benaderen. Daarvoor plaatsen we deze in de registry.
	 * @return void
	 */
	protected function _initDbAdapter()
	{
		// We halen de door Zend_Application geinitialiseerde database adapter op
		$this->bootstrap('db');
		$db = $this->getResource('db');
		// plaats in de registry voor eenvoudige toegang in onze models
		if ($db != null) {
			Zend_Registry::set('db', $db);
		} else {
			throw new Exception('cannot create database adapter');
		}

		// zorg dat de klassen voor de toegang van de database (DAO) een referentie naar
		// de adapter krijgen.
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
	}

	/**
	 * We willen sessions gaan gebruiken voor tijdelijke opslag.
	 * We starten altijd het session mechanisme.
	 */
	protected function _initAutoStartSession() {
		// zorg dat de session-sectie uit de application.ini eerst wordt geinitialiseerd
		$this->bootstrap('session');
		Zend_Session::start();
	}

	/**
	 * registreer Action Helpers zodat deze worden uitgevoerd
	 *
	protected function _initActionHelpers() {
		// zorg dat de logger is geinitialiseerd voordat de helper wordt aangeroepen.
		// Dan kunnen we log informatie opnemen in de helper
		$this->bootstrap('logger');
		Zend_Controller_Action_HelperBroker::addHelper(new Excen_Controller_Action_Helper_Acl());
		Zend_Controller_Action_HelperBroker::addHelper(new Excen_Controller_Action_Helper_Navigation());
	}*/

	/**
	 * We registreren een globale shortcut functie voor het vertalen
	 * van onze teksten. De functie wordt tijdens de bootstrap gedeclareerd
	 * en is daarvoor niet beschikbaar
         */
	protected function _initTranslationShortCut()
	{
            $this->bootstrap('locale');
	    $this->bootstrap('translate');

	    function __($messageId, $locale = null)
	    {
                return Zend_Registry::get('Zend_Translate')->translate($messageId, $locale);
	    }
	}
        
        protected function _initConfig()
        {
            //$config = new Zend_Config($this->getOptions(), true);
            $config = new Zend_Config($this->getOptions());
            Zend_Registry::set('config', $config);
            return $config;
        }

//        /**
//         *
//         */
//        protected function _initRouter()
//        {
//            $frontController = Zend_Controller_Front::getInstance();
//            $request = $frontController->getRequest();
//            var_dump($this->getModuleName());
//            $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/route.ini');
//            //var_dump($config->routes->home);
//            //exit;
//            $router = $frontController->getRouter();
//            $router->addConfig($config,'routes');
//        }

    /**
     *
     * load a module specific config file
     */
//    protected function _loadModuleConfig()
//    {
//        // would probably better to use
//        // Zend_Controller_Front::getModuleDirectory() ?
//        $configFile = APPLICATION_PATH
//            . '/modules/'
//            . strtolower($this->getModuleName())
//            . '/configs/module.ini';
//
//        if (!file_exists($configFile)) {
//            return;
//        }
//
//        $config = new Zend_Config_Ini($configFile, $this->getEnvironment());
//        $this->setOptions($config->toArray());
//
//    }
        /**
	 * initialiseer de CSS-stylesheets
	 * @return void
	 */
//	public function activeInitCss()
//	{
//            var_dump('sdfdfdf');
//	}

    /**
     * ZFDebug - a debug bar for Zend Framework
     * ZFDebug is a plugin for the Zend Framework for PHP5.
     * It provides useful debug information displayed in a small bar at the bottom of every page.
     * Time spent, memory usage and number of database queries are presented at a glance.
     * Additionally, included files, a listing of available view variables and the complete SQL command of all queries
     * are shown in separate panels (shown configured with 2 database adapters):
     */
    protected function _initZFDebug()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug');

        $options = array(
            'plugins' => array('Variables',
                               'File' => array('base_path' => '/path/to/project'),
                               'Memory',
                               'Time',
                               'Registry',
                               'Exception'
                               )
        );

        # Instantiate the database adapter and setup the plugin.
        # Alternatively just add the plugin like above and rely on the autodiscovery feature.
        if ($this->hasPluginResource('db')) {
            $this->bootstrap('db');
            $db = $this->getPluginResource('db')->getDbAdapter();
            $options['plugins']['Database']['adapter'] = $db;
        }

        # Setup the cache plugin
        if ($this->hasPluginResource('cache')) {
            $this->bootstrap('cache');
            $cache = $this-getPluginResource('cache')->getDbAdapter();
            $options['plugins']['Cache']['backend'] = $cache->getBackend();
        }

        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin($debug);
    }

}