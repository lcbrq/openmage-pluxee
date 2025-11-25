<?php


$installer = $this;
$installer->startSetup();

$productsTable = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/product'))
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
            'product_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Pluxee ID'
        )
        ->addColumn(
            'sku',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'SKU'
        )
        ->addColumn(
            'label',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Name'
        )
        ->addColumn(
            'picture',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Image'
        )
        ->addColumn(
            'price',
            Varien_Db_Ddl_Table::TYPE_FLOAT,
            null,
            array(),
            'Price'
        )
        ->addColumn(
            'reference_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Pluxee Reference ID'
        )
        ->addColumn(
            'brand_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Pluxee Brand ID'
        )
        ->addColumn(
            'description',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '64k',
            array(),
            'Description'
        )
        ->addColumn(
            'tags',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '1024',
            array(),
            'Tags'
        )
        ->addColumn(
            'stock',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Qty'
        )
        ->addColumn(
            'active',
            Varien_Db_Ddl_Table::TYPE_SMALLINT,
            null,
            array(),
            'Active'
        )
        ->addColumn(
            'position',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Position'
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
        );
$installer->getConnection()->createTable($productsTable);

$brandsTable = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/brand'))
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
            'Primary entry eky'
        )
        ->addColumn(
            'brand',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Brand'
        )
        ->addColumn(
            'brand_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Pluxee ID'
        )
        ->addColumn(
            'label',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Label'
        )
        ->addColumn(
            'picture',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Image'
        )
        ->addColumn(
            'description',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '64k',
            array(),
            'Description'
        )
        ->addColumn(
            'url',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Url'
        )
        ->addColumn(
            'active',
            Varien_Db_Ddl_Table::TYPE_SMALLINT,
            null,
            array(),
            'Active'
        )
        ->addColumn(
            'position',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Position'
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
        );
$installer->getConnection()->createTable($brandsTable);

$categoryTable = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/category'))
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
            'Primary entry eky'
        )
        ->addColumn(
            'category_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Pluxee ID'
        )
        ->addColumn(
            'label',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Title'
        )
        ->addColumn(
            'picture',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Image'
        )
        ->addColumn(
            'active',
            Varien_Db_Ddl_Table::TYPE_SMALLINT,
            null,
            array(),
            'Active'
        )
        ->addColumn(
            'position',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Position'
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
        );
$installer->getConnection()->createTable($categoryTable);

$vocherCategoryTable = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/product_category'))
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(),
        'Product ID'
    )
    ->addColumn(
        'category_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ),
        'Category Id'
    )
    ->addColumn(
        'position',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(),
        'Position'
    );
$installer->getConnection()->createTable($vocherCategoryTable);

$purchaseTable = $installer->getConnection()->newTable($installer->getTable('lcb_pluxee/order'))
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
            'Primary entry eky'
        )
        ->addColumn(
            'customer_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Customer ID'
        )
        ->addColumn(
            'order_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Order ID'
        )
        ->addColumn(
            'product_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array(),
            'Product ID'
        )
        ->addColumn(
            'grand_total',
            Varien_Db_Ddl_Table::TYPE_FLOAT,
            null,
            array(),
            'Grand Total'
        )
        ->addColumn(
            'serial',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Serial'
        )
        ->addColumn(
            'pin',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '255',
            array(),
            'Pin'
        )
        ->addColumn(
            'info',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '64k',
            array(),
            'Info'
        )
        ->addColumn(
            'expires',
            Varien_Db_Ddl_Table::TYPE_DATETIME,
            null,
            array(),
            'Expires At'
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
        );
$installer->getConnection()->createTable($purchaseTable);

$installer->endSetup();
