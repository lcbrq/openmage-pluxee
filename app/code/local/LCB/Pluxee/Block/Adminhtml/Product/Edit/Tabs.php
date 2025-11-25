<?php

class LCB_Pluxee_Block_Adminhtml_Product_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('product_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('lcb_pluxee')->__('Item Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('lcb_pluxee')->__('About Product'),
            'title' => Mage::helper('lcb_pluxee')->__('About Product'),
            'content' => $this->getLayout()->createBlock('lcb_pluxee/adminhtml_product_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
