<?php

class Inchoo_Tickets_Block_Adminhtml_Active_Customer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $customer_id = $row->getData('customer_id_fk');
        return Mage::getModel('customer/customer')
            ->load($customer_id)
            ->getName();
    }
}