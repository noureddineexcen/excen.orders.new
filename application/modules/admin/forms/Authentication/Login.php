<?php
class Admin_Form_Authentication_Login extends Zend_Form {

    public function init() {
    // gebruik een eigen view-script voor de rendering van het form
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'forms/form_authentication_login.phtml'))
        ));
        $this->setMethod(Zend_Form::METHOD_POST);

        // maken van form elementen
        $username   = $this->createElement('text', 'username');
        $password   = $this->createElement('password', 'password');
//        $redirect   = $this->createElement('hidden', 'redirect');
        $submit     = $this->createElement('submit', 'login');

        // labels toekennen aan de elementen
        $username->setLabel('Gebruiker');
        $password->setLabel('Wachtwoord');
        $submit->setLabel('Login');
        // de elementen toevoegen aan het formulier
//        $this->addElements(array($username, $password, $redirect, $submit));
        $this->addElements(array($username, $password, $submit));
        // De decorators voor alle toegevoegde elementen instellen
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'td')),
            array('Label'),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        ));

        // de decorators voor het submit element aanpassen,
        // zodat het label niet getoond wordt maar de td wel
        $submit->setDecorators(array(
            'ViewHelper',
            array(array('data' => 'HtmlTag'), array('tag' => 'td')),
            array(array('labelAlias' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        ));
    }
}