<?php
class Test_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $oTest = new Test_Model_Test();
        echo $oTest->test();
         $oTesta = new Site_Model_Test();
         var_dump($oTesta->test());

    }
    
}
