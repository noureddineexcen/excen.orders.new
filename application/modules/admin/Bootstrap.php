<?php
/**
 * Lege bootstrap klasse voor de admin module
 * In deze klasse kunnen we speciale initialisatie doen voor de module 
 *
 * @author Wouter Tengeler
 */
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
//            /**
//         *
//         */
//        protected function _initRouter()
//        {
//            $this->getPluginResource('modules');
//            $frontController = Zend_Controller_Front::getInstance();
//            $request = $frontController->getRequest();
//            var_dump($this->getModuleName());
//           // $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/route.ini');
//            //var_dump($config->routes->home);
//            //exit;
//            //$router = $frontController->getRouter();
//            //$router->addConfig($config,'routes');
//        }
//
            /**
	 * initialiseer de CSS-stylesheets
	 * @return void
	 */
	public function activeInitCss()
	{
            //var_dump('sdfdfdf');
	}

}
