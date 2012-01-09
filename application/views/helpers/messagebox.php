<?php
/**
 * $Id:$
 * Toon meldingen
 * Ondersteunde meldingen types:
 * -error
 * -success
 * -info
 * -warning
 *
 */
class Site_View_Helper_Messagebox extends Zend_View_Helper_Abstract
{

    /**
     *
     * @param array $aMessages
     * @return string html
     */
    public function messagebox($msgType, $message)
    {
        //ondersteunde meldingen types
        $aMessagetypes = array(
            'error',
            'success',
            'info',
            'warning'
        );

        if(!in_array($msgType, $aMessagetypes)){
            throw new Exception("Onbekend melding type '{$msgType}'");
        }

        return $this->view->partial('partials/messagebox.phtml', array(
                'message'  => $message,
                'mesType'  => $msgType,
            ));
    }
}