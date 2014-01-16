<?php

class Inchoo_Tickets_Block_Adminhtml_Thread_Author extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $author = $row->getData('author');
        return ($author == 1) ?
            Mage::helper('inchoo_tickets')->__('User') :
            Mage::helper('inchoo_tickets')->__('Admin');
    }
}