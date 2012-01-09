<?php
class Site_Form_Example_Add extends Zend_Form
{
    public function init()
    {
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'forms/form_comment_add.phtml'))
        ));
        $this->setMethod(Zend_Form::METHOD_POST);
        // maken van form elementen
        $blogpostId  = $this->createElement('hidden', 'id');
        $name        = $this->createElement('text', 'name');
        $email       = $this->createElement('text', 'email');
        $comment     = $this->createElement('textarea', 'comment');
        //$ckeditor     = $this->createElement('textareaCkeditor', 'ckeditor');
        $submit      = $this->createElement('submit', 'opslaan');

        // labels toekennen aan de elementen
        $name->setLabel('form_comment_add_name');
        $email->setLabel('form_comment_add_email');
        $comment->setLabel('form_comment_add_remark');
        //$ckeditor->setLabel('form_comment_add_ckeditor');
        $submit->setLabel('form_comment_add_save');

        // validatieregels toekennen aan de elementen
        $name->setRequired(true);
        $name->addValidator(new Zend_Validate_StringLength(3, 60));
        $email->setRequired(true);
        $email->addValidator(new Zend_Validate_EmailAddress());
        $comment->setRequired(true);
        $comment->addValidator(new Zend_Validate_StringLength(0, 200));
        //$ckeditor->setRequired(true);
        //$ckeditor->addValidator(new Zend_Validate_StringLength(0, 200));

        // de elementen toevoegen aan het formulier
        $this->addElements(array($blogpostId, $name, $email, $comment, $submit));

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