<?php

class LCB_Pluxee_Block_Adminhtml_Brand_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('brand_form', array(
            'legend' => Mage::helper('lcb_pluxee')->__('Item information'),
        ));

        $fieldset->addField('label', 'text', array(
            'label' => Mage::helper('lcb_pluxee')->__('Label'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'label',
        ));

        $fieldset->addField('description', 'textarea', array(
            'label' => Mage::helper('lcb_pluxee')->__('Description'),
            'name' => 'description',
        ));

        $fieldset->addField('url', 'text', array(
            'label' => Mage::helper('lcb_pluxee')->__('URL'),
            'name' => 'url',
        ));

        if ($brandData = Mage::getSingleton('adminhtml/session')->getBrandData()) {
            $form->setValues($brandData);
            Mage::getSingleton('adminhtml/session')->setBrandData(null);
        } elseif (Mage::registry('brand_data')) {
            $form->setValues(Mage::registry('brand_data')->getData());
        }

        return parent::_prepareForm();
    }
}
