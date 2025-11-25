<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pluxeeOrdersGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lcb_pluxee/order')->getCollection();
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

        $this->addColumn('order_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('Pluxee ID'),
            'align' => 'right',
            'width' => '50px',
            'type' => 'number',
            'index' => 'order_id',
        ));

        $this->addColumn('customer_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('Customer ID'),
            'align' => 'right',
            'width' => '50px',
            'type' => 'number',
            'index' => 'customer_id',
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('lcb_pluxee')->__('Total'),
            'index' => 'grand_total',
        ));

        $this->addColumn('serial', array(
            'header' => Mage::helper('lcb_pluxee')->__('Serial'),
            'index' => 'serial',
        ));

        $this->addColumn('expires', array(
            'header' => Mage::helper('lcb_pluxee')->__('Expires'),
            'index' => 'expires',
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
        return '#';
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        return $this;
    }
}
