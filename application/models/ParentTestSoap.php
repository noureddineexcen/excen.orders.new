<?php
/**
 * $Id$
 *
 * LET OP IN DEV DOET DIT DING ALLES VIA DB,
 * LIVE VIA SOAP
 *
 * Dient als parent voor alle models die soap nodig hebben; zet de soap client op en regelt caching
 */
class Site_Model_ParentTestSoap
{
    public $soapClient = null;
    public $db;
    public function __construct()
    {
//        $oConfig = new Zend_Config_Ini(APPLICATION_PATH . 'config/environment.ini');
//        $aConfig = $oConfig->toArray();

        //var_dump($_SERVER['DOCUMENT_ROOT'] . '/../application/data/cache');exit;
        if ( APPLICATION_ENV == 'development')
        {
            // soap
            $this->soapClient = new SoapClient(
                Zend_Registry::get('config')->wsdl,
                array(
                    'login'      => 'xxx',
                    'password'   => 'xxx',
                    'trace'      => true,
                    'cache_wsdl' => WSDL_CACHE_NONE
                )
            );
        }

        $cacheDir = $_SERVER['DOCUMENT_ROOT'] . '/../application/data/cache';
        if ( is_dir($cacheDir) == false)
        {
            mkdir($cacheDir, 0777, true);
        }
       
        // setup caching   
        $this->oCache = Zend_Cache::factory(
            'Core', // frontendName
            'File', // backendName
            array( // frontendOptions
                'caching'                 => false,
                'automatic_serialization' => true
            ),
            array( // backendOptions
                'cache_dir' => $cacheDir,
            )
        );
         
    }
   
}
