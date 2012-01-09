<?php
/**
 * This helper shows ckeditor.
 * Is used in combination with ckeditor form element
 */
class Excen_View_Helper_CkeditorElement extends Zend_View_Helper_FormElement
{

    /**
     *
     * path to ckeditor
     * @var string
     */
    protected $_sCkeditorDefaultPath = '/js/ckeditor/ckeditor.js';
    public function ckeditorElement($name, $value = null, $attribs = null)
    {
        $helper = new Zend_View_Helper_FormTextarea();
        $helper->setView($this->view);
        
        //add ckeditor script inside the header
        $this->view->headScript()->appendFile($this->_sCkeditorDefaultPath);
        $this->html .= $helper->formTextarea($name, $value = null, $attribs = null);

        //add inline script to bottom of the body
        $scripts = $this->view->inlineScript();
        $scripts->appendScript("CKEDITOR.replace( '" . $name. "' );");

        return $this->html;
    }
}
