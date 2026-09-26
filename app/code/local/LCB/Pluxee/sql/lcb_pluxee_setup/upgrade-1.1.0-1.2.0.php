<?php

/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/log'))
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
        'path',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        512,
        array(
            'nullable' => false,
        ),
        'API path'
    )
    ->addColumn(
        'method',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        10,
        array(
            'nullable' => false,
        ),
        'HTTP method'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default' => 0,
        ),
        'HTTP status code'
    )
    ->addColumn(
        'request',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        '2M',
        array(),
        'Request data'
    )
    ->addColumn(
        'response',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        '2M',
        array(),
        'Response data'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(
            'nullable' => false,
        ),
        'Created At'
    )
    ->addIndex(
        $installer->getIdxName('lcb_pluxee/log', array('created_at')),
        array('created_at')
    );

$installer->getConnection()->createTable($table);
$installer->endSetup();
