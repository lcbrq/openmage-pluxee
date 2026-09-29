<?php

class LCB_Pluxee_Model_Card extends Mage_Core_Model_Abstract
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'lcb_pluxee_card';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'card';

    protected function _construct()
    {
        $this->_init('lcb_pluxee/card');
    }
}
