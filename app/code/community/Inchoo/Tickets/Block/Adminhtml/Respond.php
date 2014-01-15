<?php

class Inchoo_Tickets_Block_Adminhtml_Respond extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'tickets_respond';
        $this->_blockGroup = 'inchoo_tickets';
        $this->_controller = 'adminhtml_respond';
        $this->_mode = 'edit';

        $this->_updateButton('save', 'label', Mage::helper('inchoo_tickets')->__('Submit reply'));
        $this->removeButton('reset');
        $this->removeButton('delete');
    }

    public function getHeaderText()
    {
        return Mage::helper('inchoo_tickets')->__('Submit reply');
    }
}