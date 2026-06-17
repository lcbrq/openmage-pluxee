<?php

class LCB_Pluxee_Block_Adminhtml_Brand_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('brand_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('lcb_pluxee')->__('Brand Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('lcb_pluxee')->__('About Brand'),
            'title' => Mage::helper('lcb_pluxee')->__('About Brand'),
            'content' => $this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
