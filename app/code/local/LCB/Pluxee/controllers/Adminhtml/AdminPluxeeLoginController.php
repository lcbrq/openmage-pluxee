<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Adminhtml_AdminPluxeeLoginController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/pluxee');
    }

    /**
     * @return void
     */
    public function authenticateAction()
    {
        try {
            Mage::getModel('lcb_pluxee/api')->login();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Login successful'));
        } catch (\Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirectReferer();
    }

    /**
     * @return void
     */
    public function logoutAction()
    {
        try {
            Mage::getModel('lcb_pluxee/api')->logout();
            Mage::getSingleton('adminhtml/session')->addNotice($this->__('Logout successful'));
        } catch (\Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirectReferer();
    }
}
