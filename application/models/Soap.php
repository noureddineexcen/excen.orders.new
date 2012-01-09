<?php
/**
 * Endpoint voor de faxservice soap services
 */

ini_set('xdebug.remote_enable', 'off');

set_include_path(realpath(dirname(__FILE__) . '/../') . '/library/');

require_once('Zend/Loader/Autoloader.php');

$loader = Zend_Loader_Autoloader::getInstance();
$loader->setFallbackAutoloader(true);

// todo live gegevens
$db     = Zend_Db::factory('mysqli', array(
        'host'     => 'dev2.admin.netexpo.nl',
        'username' => 'faxservicesoap',
        'password' => 'fkXcn2di',
        'dbname'   => 'netexpo',
        'charset'  => 'utf8'
    )
);

Zend_Registry::set('db',$db);

// testen zonder soap
if( isset($_GET['nosoap']) == true)
{
    $s = new ServicedeskFax();
    //var_dump($s->getAvailableFaxnumbers(31,10));
}

// testen met een client
if ( isset($_GET['client']) == true)
{
    $s = new SoapClient('http://' . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['PHP_SELF'] . '?wsdl');
    //var_dump($s->getCountries());
}


if (isset($_GET['wsdl']))
{
    $autodiscover = new Zend_Soap_AutoDiscover();
    $autodiscover->setClass('ServicedeskFax');
    $autodiscover->handle();
}
else
{
    $soap = new Zend_Soap_Server('http://' . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['PHP_SELF'] . '?wsdl');
    $soap->setClass('ServicedeskFax');
    $soap->handle();
}