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
}