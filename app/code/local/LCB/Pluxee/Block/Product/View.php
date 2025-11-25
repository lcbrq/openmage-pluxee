<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Product_View extends Mage_Core_Block_Template
{
    /**
     * @return Varien_Object
     */
    public function getProduct()
    {
        $productId = $this->getRequest()->getParam('id');

        return Mage::getModel('lcb_pluxee/product')->load($productId);
    }
}
