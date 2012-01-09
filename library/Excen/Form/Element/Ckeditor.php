<?php
class LeerJezelf_Form_Element_Ckeditor extends Zend_Form_Element_Xhtml
{
    public $helper = 'ckeditorElement';

    public function  setValue($value) {
        parent::setValue($value);
    }
    public function getValue()
    {
        return '111 11 11 11';
    }
}