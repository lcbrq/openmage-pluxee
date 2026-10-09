<?php

class LCB_Pluxee_Model_System_Config_Source_Product_Brand
{
    /**
     * @return array
     */
    public function toArray()
    {
        $collection = Mage::getModel('lcb_pluxee/brand')->getCollection();
        $options = [];
        foreach ($collection as $brand) {
            $options[$brand->getBrandId()] = $brand->getLabel();
        }

        return $options;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = Mage::getModel('lcb_pluxee/brand')->getCollection();
        $options = [];
        foreach ($collection as $brand) {
            $options[] = [
                'value' => $brand->getBrandId(),
                'label' => $brand->getLabel(),
            ];
        }

        return $options;
    }
}
