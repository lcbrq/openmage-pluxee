<?php

/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn(
    $installer->getTable('lcb_pluxee/card'),
    'user_id',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'unsigned' => true,
        'nullable' => true,
        'comment' => 'User ID',
        'after' => 'customer_id',
    )
);

$installer->getConnection()->addColumn(
    $installer->getTable('lcb_pluxee/card'),
    'type',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 64,
        'nullable' => true,
        'comment' => 'Type',
        'after' => 'amount',
    )
);

$installer->endSetup();
