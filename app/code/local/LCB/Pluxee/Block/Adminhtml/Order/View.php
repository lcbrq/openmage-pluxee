<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Order_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        parent::__construct();
        $this->_blockGroup = 'lcb_pluxee';
        $this->_controller = 'adminhtml_order';
        $this->_mode = 'view';

        $this->removeButton('save');
        $this->removeButton('delete');
        $this->removeButton('reset');
    }

    public function getHeaderText()
    {
        $order = Mage::registry('order_data');

        if ($order && $order->getId()) {
            return Mage::helper('lcb_pluxee')->__('Order #%s', $order->getOrderId() ?: $order->getId());
        }

        return Mage::helper('lcb_pluxee')->__('Order');
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }
}
