<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Card_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pluxeeCardsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lcb_pluxee/card')->getCollection();
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

        $this->addColumn('customer_id', array(
            'header' => Mage::helper('lcb_pluxee')->__('Customer ID'),
            'align' => 'right',
            'width' => '50px',
            'type' => 'number',
            'index' => 'customer_id',
        ));

        $this->addColumn('number', array(
            'header' => Mage::helper('lcb_pluxee')->__('Number'),
            'index' => 'number',
        ));

        $this->addColumn('type', array(
            'header' => Mage::helper('lcb_pluxee')->__('Type'),
            'index' => 'type',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('lcb_pluxee')->__('Created At'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'datetime',
            'index'     => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('lcb_pluxee')->__('Updated At'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'datetime',
            'index'     => 'updated_at',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }
}
