<?php

class Inchoo_Tickets_Block_Adminhtml_Closed extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_tickets';
        $this->_controller = 'adminhtml_closed';
        $this->_headerText = Mage::helper('inchoo_tickets')->__('Customer tickets');

        parent::__construct();

        $this->removeButton('add');
    }
}