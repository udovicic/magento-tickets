<?php

class Inchoo_Tickets_Block_Adminhtml_Active extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_tickets';
        $this->_controller = 'adminhtml_active';
        $this->_headerText = Mage::helper('inchoo_tickets')->__('Active customer tickets');

        parent::__construct();

        $this->removeButton('add');
    }
}