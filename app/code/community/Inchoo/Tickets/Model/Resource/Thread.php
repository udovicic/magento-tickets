<?php

class Inchoo_Tickets_Model_Resource_Thread extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tickets/thread', 'thread_id');
    }
}