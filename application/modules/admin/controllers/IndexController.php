<?php
class Admin_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {

        $oUser = new Site_Model_User;
        var_dump($oUser->load(1)->getFirstName());

        //$oTest = new Admin_Model_Test();
        //echo $oTest->test();

    }
    
}
