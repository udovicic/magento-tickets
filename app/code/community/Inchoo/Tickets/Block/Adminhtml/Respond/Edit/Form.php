<?php

class Inchoo_Tickets_Block_Adminhtml_Respond_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/respond', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('tickets_form', array(
            'legend' => Mage::helper('inchoo_tickets')->__('Submit new reply')
        ));

        $fieldset->addField('message', 'textarea', array(
            'label' => Mage::helper('inchoo_tickets')->__('Enter message'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'message'
        ));

        return parent::_prepareForm();
    }
}