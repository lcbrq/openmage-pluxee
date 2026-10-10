<?php

/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/order_item'))
    ->addColumn(
        'item_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ),
        'Primary entry key'
    )
    ->addColumn(
        'order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ),
        'Order ID'
    )
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => true,
        ),
        'Product ID'
    )
    ->addColumn(
        'reference_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'nullable' => true,
        ),
        'Pluxee Reference ID'
    )
    ->addColumn(
        'price',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        null,
        array(
            'nullable' => true,
        ),
        'Price'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(),
        'Created At'
    )
    ->addIndex(
        $installer->getIdxName('lcb_pluxee/order_item', array('order_id')),
        array('order_id')
    )
    ->setComment('lcb_pluxee_order_item');

$installer->getConnection()->createTable($table);

$installer->endSetup();
