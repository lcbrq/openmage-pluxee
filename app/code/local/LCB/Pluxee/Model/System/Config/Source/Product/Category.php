<?php

class LCB_Pluxee_Model_System_Config_Source_Product_Category
{
    /**
     * @return array
     */
    public function toArray()
    {
        $collection = Mage::getModel('lcb_pluxee/category')->getCollection();
        $options = [];
        foreach ($collection as $category) {
            $options[$category->getCategoryId()] = $category->getLabel();
        }

        return $options;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = Mage::getModel('lcb_pluxee/category')->getCollection();
        $options = [];
        foreach ($collection as $category) {
            $options[] = [
                'value' => $category->getCategoryId(),
                'label' => $category->getLabel(),
            ];
        }

        return $options;
    }
}
