<?php

class Inchoo_Tickets_Block_Adminhtml_Active_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('active_tickets');
        $this->setDefaultSort('thread_id', 'DESC');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $tickets = Mage::getModel('tickets/thread')
            ->getCollection()
            ->addFieldToFilter('status', '1');
        $tickets->getSelect()
            ->join(
                array('c' => 'customer_entity'),
                'main_table.customer_id_fk = c.entity_id',
                array('customer_email' => 'c.email'))
            ->join(
                array('s' => 'core_store'),
                'main_table.store_id_fk = s.store_id',
                array('store_name' => 's.name'))
        ;

        $this->setCollection($tickets);
        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addcolumn('thread_id', array(
            'header' => Mage::helper('inchoo_tickets')->__('Ticket #'),
            'sortable' => true,
            'width' => '50px',
            'filter' => false,
            'index' => 'thread_id',
        ));

        $this->addColumn('customer_email', array(
            'header' => Mage::helper('inchoo_tickets')->__('Customer email'),
            'index' => 'customer_email',
            'width' => '50px',
        ));

        $this->addcolumn('subject', array(
            'header' => Mage::helper('inchoo_tickets')->__('Subject'),
            'index' => 'subject',
        ));

        $this->addColumn('store_name', array(
            'header' => Mage::helper('inchoo_tickets')->__('Store'),
            'index' => 'store_name',
            'width' => '20px',
        ));

        $this->addColumn('close', array(
            'header' => Mage::helper('inchoo_tickets')->__('Close'),
            'width' => '20px',
            'sortable' => false,
            'filter' => false,
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'url' => array('base' => '*/*/close'),
                    'caption' => Mage::helper('inchoo_tickets')->__('Close'),
                    'field' => 'id',
                )
            )
        ));

        $this->addColumn('respond', array(
            'header' => Mage::helper('inchoo_tickets')->__('Respond'),
            'width' => '20px',
            'sortable' => false,
            'filter' => false,
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'url' => array('base' => '*/*/respond'),
                    'caption' => Mage::helper('inchoo_tickets')->__('Respond'),
                    'field' => 'id',
                )
            )
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return Mage::helper('adminhtml')->getUrl('*/*/respond', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/activegrid');
    }
}