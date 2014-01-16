<?php

class Inchoo_Tickets_Block_Adminhtml_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        $this->setId('tickets_tabs');
        $this->setTitle(Mage::helper('inchoo_tickets')->__('Support tickets'));
        parent::__construct();
    }

    protected function _beforeToHtml()
    {
        $this->addTab('active_tickets', array(
            'label' => Mage::helper('inchoo_tickets')->__('Active tickets'),
            'title' => Mage::helper('inchoo_tickets')->__('View active tickets'),
            'content' => $this->getLayout()->createBlock('inchoo_tickets/adminhtml_active')->toHtml(),
            'active' => true,
        ));

        /** ajaxed url */
        $this->addTab('closed_tickets', array(
            'label' => Mage::helper('inchoo_tickets')->__('Closed tickets'),
            'title' => Mage::helper('inchoo_tickets')->__('Closed tickets'),
            'class' => 'ajax',
            'url' => $this->getUrl('*/*/closedgrid', array('_current' => true)),
            'active' => false,
        ));

        return parent::_beforeToHtml();
    }
}