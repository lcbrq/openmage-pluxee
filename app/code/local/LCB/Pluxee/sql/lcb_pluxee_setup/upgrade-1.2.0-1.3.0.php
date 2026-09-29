<?php

/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('lcb_pluxee/card');

if (!$installer->getConnection()->isTableExists($tableName)) {
    $table = $installer->getConnection()->newTable($tableName)
        ->addColumn(
            'entity_id',
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
            'customer_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'Customer ID'
        )
        ->addColumn(
            'number',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(
                'nullable' => false,
            ),
            'Card Number'
        )
        ->addColumn(
            'amount',
            Varien_Db_Ddl_Table::TYPE_DECIMAL,
            '12,4',
            array(
                'nullable' => false,
                'default' => '0.0000',
            ),
            'Card Amount'
        )
        ->addColumn(
            'created_at',
            Varien_Db_Ddl_Table::TYPE_DATETIME,
            null,
            array(),
            'Created At'
        )
        ->addColumn(
            'updated_at',
            Varien_Db_Ddl_Table::TYPE_DATETIME,
            null,
            array(),
            'Updated At'
        )
        ->addIndex(
            $installer->getIdxName('lcb_pluxee/card', array('number'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
            array('number'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
        )
        ->addIndex(
            $installer->getIdxName('lcb_pluxee/card', array('customer_id')),
            array('customer_id')
        )
        ->setComment('lcb_pluxee_card');

    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
