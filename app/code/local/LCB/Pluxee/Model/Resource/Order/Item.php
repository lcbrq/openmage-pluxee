<?php

class LCB_Pluxee_Model_Resource_Order_Item extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('lcb_pluxee/order_item', 'item_id');
    }

    /**
     * @inheritDoc
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->isObjectNew() || !$object->getId() || !$object->getCreatedAt()) {
            $object->setCreatedAt(Varien_Date::now());
        }

        return parent::_beforeSave($object);
    }
}
