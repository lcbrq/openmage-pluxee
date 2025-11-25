<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 * @copyright (c) 2025, LeftCurlyBracket
 */
class LCB_Pluxee_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    public const XPATH_USER_LIMIT_DAILY = 'pluxee/limit/user_daily';

    /**
     * @var string
     */
    public const XPATH_GENERAL_LIMIT_DAILY = 'pluxee/limit/general_daily';

    /**
     * @var string
     */
    private const LOG_FILE = 'pluxee.log';

    /**
     * @param  string $message
     * @return void
     */
    public function log($message)
    {
        Mage::log($message, null, self::LOG_FILE, true);
    }

    /**
     * Get amount of points that can be spend daily per user
     *
     * @return int
     */
    public function getUserLimitDaily()
    {
        return (int) Mage::getStoreConfig(self::XPATH_USER_LIMIT_DAILY);
    }

    /**
     * Get amount of points that can be spend daily for all users
     *
     * @return int
     */
    public function getGeneralLimitDaily()
    {
        return (int) Mage::getStoreConfig(self::XPATH_GENERAL_LIMIT_DAILY);
    }
}
