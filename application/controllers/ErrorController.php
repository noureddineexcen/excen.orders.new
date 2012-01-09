<?php
/**
 * @todo log errors
 */


class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        //$this->view->headTitle(__('pagetitle_error'));
        $this->view->headTitle('pagetitle_error');

        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                //$this->view->message = __('error_page_not_found');
                $this->view->message = 'error_page_not_found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                //$this->view->message = __('error_application_error');
                $this->view->message = 'error_application_error';
                break;
        }

        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
    }


}

