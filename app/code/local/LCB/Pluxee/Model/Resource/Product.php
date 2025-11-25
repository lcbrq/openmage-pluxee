<?php

class LCB_Pluxee_Model_Resource_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Reward category table name
     *
     * @var string
     */
    protected $_productCategoryTable = 'lcb_pluxee_reward_category';

    public function _construct()
    {
        $this->_init('lcb_pluxee/product', 'entity_id');
    }

    /**
     * Get categories associated to product
     *
     * @param  LCB_Pluxee_Model_Product $product
     * @return array
     */
    public function getCategories($product)
    {
        $select = $this->_getWriteAdapter()->select()
            ->from($this->_productCategoryTable, array('position', 'category_id'))
            ->where('product_id = :product_id');
        $bind = array('product_id' => (int) $product->getId());

        return $this->_getWriteAdapter()->fetchPairs($select, $bind);
    }

    /**
     * Save category reward relation
     *
     * @param  LCB_Pluxee_Model_Product
     * @return $this
     */
    protected function _saveCategoryIds($product)
    {
        $product->setIsChangedCategoriesList(false);
        $id = $product->getId();

        /**
         * new article-part relationships
         */
        $categoryIds = $reward->getCategoryIds();

        /**
         * Ignore save on null
         */
        if ($categoryIds === null) {
            return $this;
        }

        /**
         * old product-category relationships
         */
        $oldCategoryIds = $this->getCategories($reward);

        $insert = array_diff_key($categoryIds, $oldCategoryIds);
        $delete = array_diff_key($oldCategoryIds, $categoryIds);

        /**
         * Find products ids which are presented in both arrays
         * and saved before (check $oldCategoryIds array)
         */
        $update = array_intersect_key($categoryIds, $oldCategoryIds);
        $update = array_diff_assoc($update, $oldCategoryIds);

        $adapter = $this->_getWriteAdapter();

        /**
         * Delete products from category
         */
        if (!empty($delete)) {
            $cond = array(
                'category_id IN(?)' => array_keys($delete),
                'product_id=?' => $id,
            );
            $adapter->delete($this->_productCategoryTable, $cond);
        }

        /**
         * Add products to category
         */
        if (!empty($insert)) {
            $data = array();
            foreach ($insert as $position => $categoryId) {
                $data[] = array(
                    'product_id' => (int)$id,
                    'category_id'  => (int) $categoryId,
                    'position'    => (int)$position,
                );
            }
            $adapter->insertMultiple($this->_productCategoryTable, $data);
        }

        /**
         * Update products positions in category
         */
        if (!empty($update)) {
            foreach ($update as $position => $categoryId) {
                $where = array(
                    'product_id = ?'=> (int) $id,
                    'category_id = ?' => (int) $categoryId,
                );
                $bind  = array('position' => (int)$position);
                $adapter->update($this->_productCategoryTable, $bind, $where);
            }
        }

        return $this;
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->isObjectNew() || !$object->getId() || !$object->getCreatedAt()) {
            $object->setCreatedAt(Varien_Date::now());
        }

        $object->setUpdatedAt(Varien_Date::now());

        return parent::_beforeSave($object);
    }

    /**
     * Process category data after product object save
     *
     * @param Varien_Object $object
     * @inheritDoc
     */
    protected function _afterSave(Varien_Object $object)
    {
        $this->_saveCategoryIds($object);
        return parent::_afterSave($object);
    }
}
