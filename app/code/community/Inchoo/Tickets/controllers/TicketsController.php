<?php

class Inchoo_Tickets_TicketsController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        /** get store and customer id */
        $store_id = Mage::app()->getStore()->getId();
        $customer_data = Mage::getSingleton('customer/session')->getCustomer();
        $customer_id = $customer_data->getId();

        /** retreive collection */
        $tickets = Mage::getModel('tickets/thread')->getCollection()
            ->addFieldToFilter('customer_id_fk', $customer_id)
            ->addFieldToFilter('store_id_fk', $store_id);

        /** load layout */
        Mage::register('tickets_thread', $tickets);

        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->renderLayout();
    }

    public function threadAction()
    {
        $thread_id = $this->getRequest()->getParam('id');

        $posts = Mage::getModel('tickets/post')->getcollection()
            ->addFieldtoFilter('thread_id_fk', $thread_id);
        $thread_title = Mage::getModel('tickets/thread')->load($thread_id)->getSubject();

        Mage::register('tickets_post', $posts);
        Mage::register('tickets_title', $thread_title);

        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->renderLayout();
    }
}