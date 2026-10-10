<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Order_View_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('order_view_tabs');
        $this->setDestElementId('edit_form');
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->addTab('general', array(
            'label' => Mage::helper('lcb_pluxee')->__('General Information'),
            'content' => $this->getLayout()
                ->createBlock('lcb_pluxee/adminhtml_order_view_tab_general')
                ->toHtml(),
        ));

        $this->addTab('items', array(
            'label' => Mage::helper('lcb_pluxee')->__('Items'),
            'content' => $this->getLayout()
                ->createBlock('lcb_pluxee/adminhtml_order_view_tab_items')
                ->toHtml(),
        ));

        return parent::_prepareLayout();
    }
}
