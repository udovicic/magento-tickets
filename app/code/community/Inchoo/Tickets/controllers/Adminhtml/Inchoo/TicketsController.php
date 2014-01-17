<?php

class Inchoo_Tickets_Adminhtml_Inchoo_TicketsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * List all active and closed tickets through tabbed interface
     */
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('inchoo_tickets')
            ->_addLeft($this->getLayout()->createBlock('inchoo_tickets/adminhtml_tabs'))
            ->renderLayout();
    }

    /**
     * Submit response to ticket
     */
    public function respondAction()
    {
        $message = $this->getRequest()->getParam('message');
        $thread_id = $this->getRequest()->getParam('id');

        /** submit response */
        if ($message != null) {
            $ticket = Mage::getModel('tickets/post')
                ->setThreadIdFk($thread_id)
                ->setAuthor(0)
                ->setMessage($message)
                ->save();

            /** Send email notification */
            if (Mage::helper('inchoo_tickets')->notifyCustomer() == 1) {
                $customer_id = Mage::getModel('tickets/thread')
                    ->load($thread_id)
                    ->getCustomerIdFk();
                $customer_email = Mage::getModel('customer/customer')
                            ->load($customer_id)
                            ->getEmail();
                $customer_name = Mage::getModel('customer/customer')
                    ->load($customer_id)
                    ->getName();

                Mage::getModel('core/email_template')
                    ->setDesignConfig(array('area' => 'frontend', 0))//'store' => $storeId))
                    ->sendTransactional(
                        Mage::helper('inchoo_tickets')->getEmailTemplateCustomer(),
                        array(
                            'email' => Mage::helper('inchoo_tickets')->getEmailSender(),
                            'name' => 'Admin',
                        ),
                        $customer_email,
                        null,
                        array(
                            'customer_name' => $customer_name,
                            'ticket_url' => Mage::getUrl('support/tickets/thread', array('id' => $thread_id)),
                            'ticket_subject' => Mage::getModel('tickets/thread')
                                    ->load($thread_id)->getSubject(),
                            'site_url' => Mage::getUrl(),
                            'site_name' => Mage::app()->getWebsite()->getName(),
                        )
                    );
            }
        }

        /** Load form and previous messages */
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

    /**
     * Mark ticket as opened
     */
    public function reopenAction()
    {
        $thread_id = $this->getRequest()->getParam('id');
        Mage::getModel('tickets/thread')
            ->load($thread_id)
            ->setStatus(1)
            ->save();

        $this->_redirect('*/*/index', array('_current' => true));
    }

    /**
     * Delete ticket and related posts
     */
    public function deleteAction()
    {
        $thread_id = $this->getRequest()->getParam('id');

        /** Remove post entries */
        $posts = Mage::getModel('tickets/post')
            ->getCollection()
            ->addFieldToFilter('thread_id_fk', $thread_id);
        foreach ($posts as $post) $post->delete();

        /** Remove ticket */
        Mage::getModel('tickets/thread')
            ->load($thread_id)
            ->delete();

        $this->_redirect('*/*/index', array('_current' => true));
    }

    /**
     * functions *gridAction() are used for grid sorting through ajax
     */
    public function activegridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock(
            'inchoo_tickets/adminhtml_active_grid')->toHtml()
        );
    }

    public function closedgridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock(
                'inchoo_tickets/adminhtml_closed_grid')->toHtml()
        );
    }
}