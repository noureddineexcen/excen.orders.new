<?php
class Site_Form_Example_Ckeditor extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $ckeditor  = new Excen_Form_Element_Ckeditor('ckeditor');
        $ckeditor->setLabel('Ckeditor')->setRequired(true);
        $submit = new Zend_Form_Element_Submit('submit');
        $this->addElements(array($ckeditor, $submit));
    }
}