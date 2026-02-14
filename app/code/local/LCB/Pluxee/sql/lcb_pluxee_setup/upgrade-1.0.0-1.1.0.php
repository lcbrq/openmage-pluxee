<?php

/**
 * Add pluxee_card number attribute
 */
/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->addAttribute('customer', 'pluxee_card_number', array(
    'label'             => 'Pluxee Card Number',
    'type'              => 'varchar',
    'input'             => 'text',
    'global'            =>  Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           =>  true,
    'required'          =>  false,
    'unique'            =>  true,
));

Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'pluxee_card_number')
    ->setData('used_in_forms', array(
        'adminhtml_customer',
    ))
    ->save();

$installer->endSetup();
