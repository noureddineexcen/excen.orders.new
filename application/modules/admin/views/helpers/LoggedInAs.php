<?php
class Site_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{
    public function loggedInAs ()
    {

        $auth = Zend_Auth::getInstance();
        //var_dump($auth->getIdentity());
        if ($auth->hasIdentity()) {
            //exit;
            $username = $auth->getIdentity()->username;
            $logoutUrl = $this->view->url(array('module' => 'admin', 'controller'=>'authentication',
                'action'=>'logout'), null, true);
            return 'Welcome ' . $username .  '. <a href="'.$logoutUrl.'">Logout</a>';
        }

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if($controller == 'auth' && $action == 'index') {
            return '';
        }
        $loginUrl = $this->view->url(array('module' => 'admin', 'controller'=>'authentication', 'action'=>'index'));
        return '<a href="'.$loginUrl.'">Login</a>';
    }
}

