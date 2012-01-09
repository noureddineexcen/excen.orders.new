<?php
class Site_Form_Example_Compositeelement extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $phone  = new Excen_Form_Element_Phone('phone');
        $phone->setLabel('Phone')->setRequired(true);
        $submit = new Zend_Form_Element_Submit('submit');
        $this->addElements(array($phone, $submit));
    }
}