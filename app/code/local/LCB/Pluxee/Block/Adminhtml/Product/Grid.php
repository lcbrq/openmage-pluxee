<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pluxeeProductsGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lcb_pluxee/product')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'type' => 'number',
            'index' => 'entity_id',
        ));

        $this->addColumn('product_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('Product ID'),
            'index' => 'product_id',
        ));

        $this->addColumn('item_type', array(
            'header' => Mage::helper('lcb_pluxee')->__('Type'),
            'index' => 'item_type',
            'type' => 'options',
            'options' => Mage::getSingleton('lcb_pluxee/system_config_source_product_type')->toArray(),
        ));

        $this->addColumn('label', array(
            'header' => Mage::helper('lcb_pluxee')->__('Label'),
            'index' => 'label',
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('lcb_pluxee')->__('Price'),
            'index' => 'price',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('lcb_pluxee')->__('Created At'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'datetime',
            'index'     => 'created_at',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * @param Varien_Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        return $this;
    }
}
