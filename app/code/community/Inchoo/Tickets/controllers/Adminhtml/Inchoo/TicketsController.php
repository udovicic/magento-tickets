<?php

class Inchoo_Tickets_Adminhtml_Inchoo_TicketsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('inchoo_tickets')
            ->_addLeft($this->getLayout()->createBlock('inchoo_tickets/adminhtml_tabs'))
            ->renderLayout();
    }

    public function respondAction()
    {
        $message = $this->getRequest()->getParam('message');
        $thread_id = $this->getRequest()->getParam('id');

        if ($message != null) {
            $ticket = Mage::getModel('tickets/post')
                ->setThreadIdFk($thread_id)
                ->setAuthor(0)
                ->setMessage($message)
                ->save();
        }

        $this->loadLayout()->
            _setActiveMenu('inchoo_tickets')
            ->_addContent($this->getLayout()->createBlock('inchoo_tickets/adminhtml_respond'))
            ->_addContent($this->getLayout()->createBlock('inchoo_tickets/adminhtml_thread'))
            ->renderLayout();
    }

    /**
     * Mark ticket as closed
     */
    public function closeAction()
    {
        $thread_id = $this->getRequest()->getParam('id');
        Mage::getModel('tickets/thread')
            ->load($thread_id)
            ->setStatus(0)
            ->save();

        $this->_redirect('*/*/index', array('_current' => true));
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

    public function threadgridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock(
                'inchoo_tickets/adminhtml_thread')->toHtml()
        );
    }
}