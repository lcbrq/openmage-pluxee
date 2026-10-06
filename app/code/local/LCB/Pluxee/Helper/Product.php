<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 * @copyright (c) 2025, LeftCurlyBracket
 */
class LCB_Pluxee_Helper_Product extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    public const XPATH_MAGNETIC_CARD_ID = 'pluxee/cards_topup/magnetic_card_id';

    /**
     * @var string
     */
    public const XPATH_MAGNETIC_TOPUP_ID = 'pluxee/cards_topup/magnetic_topup_id';

    /**
     * @var string
     */
    public const XPATH_VIRTUAL_CARD_ID = 'pluxee/cards_topup/virtual_card_id';

    /**
     * @var string
     */
    public const XPATH_VIRTUAL_TOPUP_ID = 'pluxee/cards_topup/virtual_topup_id';

    /**
     * Get the card product configured for the given card type, falling back
     * to the legacy label-based lookup when no product is configured.
     *
     * @param  string $type 'magnetic' or 'virtual'
     * @return LCB_Pluxee_Model_Product
     */
    public function getCard($type)
    {
        $xpath = $type === 'magnetic' ? self::XPATH_MAGNETIC_CARD_ID : self::XPATH_VIRTUAL_CARD_ID;
        $label = $type === 'magnetic'
            ? 'Karta Pluxee Nagroda - nośnik fizyczny'
            : 'Karta Pluxee Nagroda - nośnik wirtualny';

        return $this->_getConfiguredOrFallbackProduct($xpath, $label);
    }

    /**
     * Get the top-up product configured for the given card type, falling
     * back to the legacy label-based lookup when no product is configured.
     *
     * @param  string $type 'magnetic' or 'virtual'
     * @return LCB_Pluxee_Model_Product
     */
    public function getTopup($type)
    {
        $xpath = $type === 'magnetic' ? self::XPATH_MAGNETIC_TOPUP_ID : self::XPATH_VIRTUAL_TOPUP_ID;
        $label = $type === 'magnetic'
            ? 'Doładowanie fizycznej Karty Pluxee Nagroda'
            : 'Doładowanie Karty Pluxee Nagroda wirtualna';

        return $this->_getConfiguredOrFallbackProduct($xpath, $label);
    }

    /**
     * @param  string $xpath
     * @param  string $fallbackLabel
     * @return LCB_Pluxee_Model_Product
     */
    protected function _getConfiguredOrFallbackProduct($xpath, $fallbackLabel)
    {
        $productId = Mage::getStoreConfig($xpath);

        if ($productId) {
            $product = Mage::getModel('lcb_pluxee/product')->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }

        return Mage::getModel('lcb_pluxee/product')->getCollection()
            ->addFieldToFilter('label', $fallbackLabel)
            ->getFirstItem();
    }
}
