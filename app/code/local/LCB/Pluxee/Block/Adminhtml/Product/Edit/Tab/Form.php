<?php

class LCB_Pluxee_Block_Adminhtml_Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('product_form', array('legend' => Mage::helper('lcb_pluxee')->__('Item information')));

        $fieldset->addField("active", "select", array(
            "label" => Mage::helper("lcb_pluxee")->__("Active"),
            "name" => "active",
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
        ));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('lcb_pluxee')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('description', 'textarea', array(
            'label' => Mage::helper('lcb_pluxee')->__('Description'),
            'class' => '',
            'name' => 'description',
        ));

        $fieldset->addField('purchase_info', 'textarea', array(
            'label' => Mage::helper('lcb_pluxee')->__('Purchase Info'),
            'class' => '',
            'name' => 'purchase_info',
        ));

        $fieldset->addField('worth', 'text', array(
            'label' => Mage::helper('lcb_pluxee')->__('Value'),
            'class' => '',
            'name' => 'worth',
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('lcb_pluxee')->__('Image'),
            'name' => 'image',
            'note' => '(*.jpg, *.png, *.gif)',
        ));

        $fieldset->addField('position', 'text', array(
            'label' => Mage::helper('lcb_pluxee')->__('Position'),
            'name' => 'position',
        ));

        if ($productData = Mage::getSingleton('adminhtml/session')->getProductData()) {
            $form->setValues($productData);
            Mage::getSingleton('adminhtml/session')->setProductData(null);
        } elseif (Mage::registry('product_data')) {
            $form->setValues(Mage::registry('product_data')->getData());
        }
        return parent::_prepareForm();
    }
}
