<?php

class Inchoo_Tickets_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tickets/post', 'ticket_id');
    }
}