<?php

class Inchoo_Tickets_Adminhtml_Inchoo_TicketsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('inchoo_tickets');
        $this->_addLeft($this->getLayout()->createBlock('inchoo_tickets/adminhtml_tabs'));
        $this->renderLayout();
    }

    public function activegridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock(
            'inchoo_tickets/adminhtml_active')->toHtml()
        );
    }

    public function closedgridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock(
                'inchoo_tickets/adminhtml_closed')->toHtml()
        );
    }
}