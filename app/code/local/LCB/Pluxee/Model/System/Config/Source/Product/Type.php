<?php

/**
 * @internal STR-19
 */
class LCB_Pluxee_Model_System_Config_Source_Product_Type
{
    /**
     * @var string
     */
    public const CARD = 100;

    /**
     * @var string
     */
    public const REWARD = 0;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::CARD => Mage::helper('lcb_pluxee')->__('Card'),
            self::REWARD  => Mage::helper('lcb_pluxee')->__('Reward'),
        ];
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::CARD,
                'label' => Mage::helper('lcb_pluxee')->__('Card'),
            ),
            array(
                'value' => self::REWARD,
                'label' => Mage::helper('lcb_pluxee')->__('Reward'),
            ),
        );
    }
}
