<?php

class Inchoo_Tickets_Model_Resource_Post_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('tickets/post');
    }
}