<?php

class Inchoo_Tickets_Block_Adminhtml_Thread extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_tickets';
        $this->_controller = 'adminhtml_thread';
        $this->_headerText = '';

        parent::__construct();

        $this->removeButton('add');
    }
}