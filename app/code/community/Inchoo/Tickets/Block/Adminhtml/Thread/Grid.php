<?php

class Inchoo_Tickets_Block_Adminhtml_Thread_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('thread_tickets');
        $this->setDefaultSort('ticket_id', 'DESC');
        $this->setUseAjax(true);
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
    }

    protected function _prepareCollection()
    {
        $thread_id = $this->getRequest()->getParam('id');
        $tickets = Mage::getModel('tickets/post')
            ->getCollection()
            ->addFieldToFilter('thread_id_fk', $thread_id);

        $this->setCollection($tickets);
        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addcolumn('ticket_id', array(
            'header' => Mage::helper('inchoo_tickets')->__('Ticket #'),
            'sortable' => false,
            'width' => '50px',
            'filter' => false,
            'index' => 'ticket_id',
        ));

        $this->addColumn('author', array(
            'header' => Mage::helper('inchoo_tickets')->__('Author'),
            'index' => 'author',
            'renderer' => 'Inchoo_Tickets_Block_Adminhtml_Thread_Author',
            'filter' => false,
            'sortable' => false,
            'width' => '50px',
        ));

        $this->addcolumn('message', array(
            'header' => Mage::helper('inchoo_tickets')->__('Message'),
            'index' => 'message',
            'filter' => false,
            'sortable' => false,
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/closedgrid');
    }
}