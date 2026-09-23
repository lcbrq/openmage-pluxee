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

        $this->addColumn('active', array(
            'header' => Mage::helper('lcb_pluxee')->__('Active'),
            'index' => 'active',
            'type' => 'options',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
        ));

        $this->addColumn('category', array(
            'header' => Mage::helper('lcb_pluxee')->__('Category'),
            'index' => 'category_id',
            'type' => 'options',
            'options' => Mage::getSingleton('lcb_pluxee/system_config_source_product_category')->toArray(),
        ));

        $this->addColumn('label', array(
            'header' => Mage::helper('lcb_pluxee')->__('Label'),
            'index' => 'label',
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('lcb_pluxee')->__('Value'),
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

        $statuses = Mage::getSingleton('adminhtml/system_config_source_enabledisable')->toOptionArray();
        array_unshift($statuses, array('label' => '', 'value' => ''));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('lcb_pluxee')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('lcb_pluxee')->__('Status'),
                    'values' => $statuses,
                ),
            ),
        ));

        return $this;
    }
}
