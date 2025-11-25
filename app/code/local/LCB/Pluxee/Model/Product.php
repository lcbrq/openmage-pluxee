<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Model_Product extends Mage_Core_Model_Abstract
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'lcb_pluxee_product';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'product';

    protected function _construct()
    {
        $this->_init('lcb_pluxee/product');
    }

    /**
     * @return LCB_Pluxee_Model_Brand
     */
    public function getBrand()
    {
        return Mage::getModel('lcb_pluxee/brand')->load($this->getBrandId(), 'brand_id');
    }

    /**
     * Get categories assigned to this product
     *
     * @return LCB_Pluxee_Model_Resource_Category_Collection|array
     */
    public function getCategoriesCollection()
    {
        $categoryIds = $this->getResource()->getCategories($this);

        if (!$categoryIds) {
            return array();
        }

        $categoryCollection = Mage::getModel('lcb_pluxee/category')->getCollection()
            ->addFieldToFilter('entity_id', ['IN' => $categoryIds]);

        return $categoryCollection;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        $image = parent::getImage();
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            $imageUrl =  str_replace('test.', '', $image);
        } elseif ($image) {
            $imageUrl = Mage::getBaseUrl('media') . $image;
        } else {
            $imageUrl = '';
        }

        return $imageUrl;
    }
}
