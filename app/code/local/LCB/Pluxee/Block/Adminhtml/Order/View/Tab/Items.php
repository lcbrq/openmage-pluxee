<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Order_View_Tab_Items extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pluxeeOrderItemsGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(false);
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
    }

    protected function _prepareCollection()
    {
        $order = Mage::registry('order_data');

        $collection = Mage::getModel('lcb_pluxee/order_item')->getCollection()
            ->addFieldToFilter('order_id', (int) $order->getId());

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('item_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'type' => 'number',
            'index' => 'item_id',
        ));

        $this->addColumn('product_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('Product ID'),
            'align' => 'right',
            'width' => '80px',
            'type' => 'number',
            'index' => 'product_id',
        ));

        $this->addColumn('reference_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('Reference ID'),
            'align' => 'right',
            'width' => '100px',
            'type' => 'number',
            'index' => 'reference_id',
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('lcb_pluxee')->__('Price'),
            'index' => 'price',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('lcb_pluxee')->__('Created At'),
            'align'     => 'left',
            'width'     => '140px',
            'type'      => 'datetime',
            'index'     => 'created_at',
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param Varien_Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '#';
    }
}
