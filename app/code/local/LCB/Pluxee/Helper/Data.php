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

    /**
     * @return Mage_Core_Model_Email_Template
     */
    public function getEmailTemplate()
    {
        $emailTemplate = Mage::getModel('core/email_template');

        $templateId = Mage::getStoreConfig('pluxee/order/email_template', Mage::app()->getStore()->getId());
        $emailTemplate->load($templateId);
        if (!$emailTemplate || !$emailTemplate->getId()) {
            $emailTemplate->loadDefault('pluxee_purchase');
        }

        Mage::dispatchEvent('lcb_pluxee_purchase_email_template', array('template' => $emailTemplate));

        return $emailTemplate;
    }

    /**
     * @param  Mage_Customer_Model_Customer $customer
     * @param  LCB_Pluxee_Model_Product     $product
     * @param  LCB_Pluxee_Model_Order       $order
     * @return bool
     */
    public function sendPurchaseEmail($customer, $product, $order)
    {
        $emailTemplate = $this->getEmailTemplate();
        $emailTemplateVariables = array(
            'customer' => $customer,
            'product' => $product,
            'order' => $order,
        );

        if ($expires = $order->getExpires()) {
            $order->setExpires(date('d.m.Y', strtotime((string) $expires)));
        }

        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
        $emailTemplate->setSenderName($senderName);
        $emailTemplate->setSenderEmail($senderEmail);

        $emailTemplate->send($customer->getEmail(), $customer->getName(), $emailTemplateVariables);

        return true;
    }
}
