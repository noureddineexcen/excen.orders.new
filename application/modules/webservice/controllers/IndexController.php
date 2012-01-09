<?php
class Webservice_IndexController extends Zend_Controller_Action
{
    public function  init() {
        parent::init();

    }
    public function indexAction()
    {
        $oTest = new Site_Model_Test();
        echo $oTest->test();

    }
    
}
