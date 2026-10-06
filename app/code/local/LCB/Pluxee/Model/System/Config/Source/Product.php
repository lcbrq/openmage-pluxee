<?php

class LCB_Pluxee_Model_System_Config_Source_Product
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            ['value' => '', 'label' => Mage::helper('lcb_pluxee')->__('-- Please Select --')],
        ];

        $collection = Mage::getModel('lcb_pluxee/product')->getCollection()
            ->addFieldToFilter('label', ['notnull' => true])
            ->setOrder('label', 'ASC');

        foreach ($collection as $product) {
            $label = $product->getLabel();
            if ($product->getSku()) {
                $label .= ' (' . $product->getSku() . ')';
            }

            $options[] = [
                'value' => $product->getId(),
                'label' => $label,
            ];
        }

        return $options;
    }
}
