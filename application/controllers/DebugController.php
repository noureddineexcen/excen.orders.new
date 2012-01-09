<?php
/**
 * Kun je gebruiken om een aantal omgevings variabelen te laten zien
 * @todo Wordt alleen getoond voor ons ip adres
 */
class DebugController extends Zend_Controller_Action
{
    public $allowedIps = array('00.00.000.000', '00.00.000.000', '00.00.000.000');

    /**
     * Blokkeer alle ips behalve ons ip
     */
    public function init()
    {
        if ( APPLICATION_ENV != 'development' && in_array($_SERVER['REMOTE_ADDR'], $this->allowedIps) == false)
        {
             die;
        }

        $this->view->layout()->disableLayout();
    }

    public function indexAction()
    {
        $sControllerName = $this->getRequest()->getControllerName();
        echo " Deze pagina is alleen te zien voor deze ip adressen : ' . implode(', ', $this->allowedIps) . '<br />";
        //echo " <a href='/$sControllerName/apc/'>APC stats</a><br />";
        //echo " <a href='/$sControllerName/clear-cache/'>Cache legen</a><br />";
        echo " <a href='/$sControllerName/phpinfo/'>Phpinfo</a><br />";
        echo " <a href='/$sControllerName/session/'>Bekijk sessie inhoud</a><br />";
        //echo " <a href='/$sControllerName/db/'>Database</a><br />";
        echo " <a href='/$sControllerName/env/'>Env</a><br />";
        die;

    }
    
    public function phpinfoAction()
    {
        phpinfo();
        die;
    }

    public function sessionAction()
    {
        //session_start();
        echo '<pre>';
        print_r($_SESSION);
        die;
    }



    /**
     * Toont de environment
     */
    public function envAction()
    {
        die(APPLICATION_ENV);
    }

    /**
     * Toont db username dbname en hostname
     */
    public function dbAction()
    {
    }

}