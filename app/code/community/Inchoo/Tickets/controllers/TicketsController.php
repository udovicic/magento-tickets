<?php

class Inchoo_Tickets_TicketsController extends Mage_Core_Controller_Front_Action
{
    /**
     * List all tickets from current customer
     */
    public function indexAction()
    {
        /** get store and customer id */
        $store_id = Mage::app()->getStore()->getId();
        $customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();

        /** retreive collection */
        $tickets = Mage::getModel('tickets/thread')->getCollection()
            ->addFieldToFilter('customer_id_fk', $customer_id)
            ->addFieldToFilter('store_id_fk', $store_id);

        /** load layout variables */
        Mage::register('tickets_thread', $tickets);

        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->renderLayout();
    }

    /**
     * List all messages inside current ticket
     */
    public function threadAction()
    {
        $thread_id = $this->getRequest()->getParam('id');

        /** Load message collection and ticket subject */
        $posts = Mage::getModel('tickets/post')->getcollection()
            ->addFieldtoFilter('thread_id_fk', $thread_id);
        $thread = Mage::getModel('tickets/thread')->load($thread_id);

        /** Sotre data in registry for use in view */
        Mage::register('tickets_post', $posts);
        Mage::register('tickets_thread', $thread);

        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->renderLayout();
    }

    /**
     * Submit new reply on existing ticket
     */
    public function replyAction()
    {
        /** Get user input */
        $message = $this->getRequest()->getParam('reply');
        $thread_id = $this->getRequest()->getParam('id');

        /** TODO: Validate data */
        /** Save message */
        $ticket = Mage::getModel('tickets/post');
        $ticket->setThreadIdFk($thread_id)
            ->setAuthor(1)
            ->setMessage($message)
            ->save();

        /** Send email notification */
        if (Mage::helper('inchoo_tickets')->notifyAdminResponse() == 1){
            $email = $email = Mage::getModel('core/email_template')->loadByCode(
                Mage::helper('inchoo_tickets')->getEmailTemplateAdminRespond());
            $vars = array(
                'customer_name' => Mage::getSingleton('customer/session')->getCustomer()->getName(),
                'ticket_url' => Mage::helper('adminhtml')
                        ->getUrl("inchoo/tickets/respond", array('id' => $thread_id)),
                'ticket_subject' => Mage::getModel('tickets/thread')
                        ->load($thread_id)->getSubject(),
                'ticket_message' => $message,
            );

            $email->getProcessedTemplate($vars);
            $email->setSenderEmail(Mage::helper('inchoo_tickets')->getEmailSender());
            $email->send(Mage::helper('inchoo_tickets')->getAdminMail());
//            ->setSubject(Mage::helper('inchoo_tickets')->getAdminEmailSubjectResponse())
        }

        /** Redirect user to thread view */
        $this->_redirect('support/tickets/thread/', array('_current' => true));
    }

    /**
     * Submit new ticket with first message
     */
    public function newAction()
    {
        $subject = $this->getRequest()->getParam('subject');
        $message = $this->getRequest()->getParam('message');

        if ($message != null && $subject != null) {
            $store_id = Mage::app()->getStore()->getId();
            $customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();

            /** Create new thread */
            $thread = Mage::getModel('tickets/thread')
                ->setCustomerIdFk($customer_id)
                ->setStoreIdFk($store_id)
                ->setSubject($subject)
                ->setStatus(1)
                ->save();
            $thread_id = $thread->getId();

            /** Submit first message */
            Mage::getModel('tickets/post')
                ->setThreadIdFk($thread_id)
                ->setAuthor(1)
                ->setMessage($message)
                ->save();

            /** Send email notification */
            if (Mage::helper('inchoo_tickets')->notifyAdminNew() == 1) {
                $email = Mage::getModel('core/email_template')->loadByCode(
                    Mage::helper('inchoo_tickets')->getEmailTemplateAdminNew());
                $vars = array(
                    'customer_name' => Mage::getSingleton('customer/session')->getCustomer()->getName(),
                    'ticket_url' => Mage::helper('adminhtml')
                            ->getUrl("inchoo/tickets/respond", array('id' => $thread_id)),
                    'site_url' => Mage::getUrl(),
                    'site_name' => Mage::app()->getWebsite()->getName(),
                    'ticket_subject' => Mage::getModel('tickets/thread')
                            ->load($thread_id)->getSubject(),
                    'ticket_message' => $message,
                );
                $email->getProcessedTemplate($vars);
                $email->setSenderEmail(Mage::helper('inchoo_tickets')->getEmailSender());
                $email->send(Mage::helper('inchoo_tickets')->getAdminMail());
//                    ->setSubject(Mage::helper('inchoo_tickets')->getAdminEmailSubjectNew())
            }

            $this->_redirect('*/*/thread', array('_current' => true, 'id' => $thread_id));
        }

        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->renderLayout();
    }
}