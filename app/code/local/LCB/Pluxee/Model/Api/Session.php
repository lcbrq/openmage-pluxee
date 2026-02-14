<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Model_Api_Session
{
    public const FLAG_CODE = 'pluxee_session';

    public function create(array $sessionData): void
    {
        $sessionFlag = Mage::getModel('core/flag', array('flag_code' => self::FLAG_CODE))->loadSelf();
        $sessionFlag->setFlagData($sessionData)->setState(1)->save();
    }

    /**
     * @return Mage_Core_Model_Flag
     */
    public function get()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::FLAG_CODE))->loadSelf();
    }

    public function destroy(): void
    {
        $this->get()->setState(0)->setFlagData([])->save();
    }
}
