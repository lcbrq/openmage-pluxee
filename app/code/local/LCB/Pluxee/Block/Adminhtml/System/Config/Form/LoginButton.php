<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_System_Config_Form_LoginButton extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Return element html
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->getElementHtml();
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/adminPluxeeLogin/authenticate');
    }

    /**
     * @return string
     */
    public function getLogoutUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/adminPluxeeLogin/logout');
    }

    /**
     * Generate test connection button html
     *
     * @return string
     */
    public function getElementHtml()
    {
        $sessionFlag = Mage::getModel('lcb_pluxee/api_session')->get();
        if ($sessionData = $sessionFlag->getFlagData()) {
            $button = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'id'        => 'lcb_pluxee',
                    'label'     => $this->helper('lcb_pluxee')->__('Logout'),
                    'onclick'   => "setLocation('" . $this->getLogoutUrl() . "'); return false;",
                ]);
            $noticeHtml = '';
            $noticeHtml = sprintf(
                '<p class="" style="margin-top: 10px;"><span>%s <code>%s</code><br/>%s <code>%s</code></span></p>',
                $this->__('Session ID:'),
                $sessionData['sessionId'] ?? '',
                $this->__('User ID:'),
                $sessionData['user_id'] ?? '',
            );
        } else {
            $button = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'id'        => 'lcb_pluxee',
                    'label'     => $this->helper('lcb_pluxee')->__('Login'),
                    'onclick'   => "setLocation('" . $this->getLoginUrl() . "'); return false;",
                ]);
            $noticeHtml = '';
        }

        return $button->toHtml() . $noticeHtml;
    }
}
