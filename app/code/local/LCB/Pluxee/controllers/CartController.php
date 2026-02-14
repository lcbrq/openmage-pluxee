<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_CartController extends Mage_Core_Controller_Front_Action
{
    public function purchaseAction()
    {
        $id = $this->getRequest()->getParam('id');
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $product = Mage::getModel('lcb_pluxee/product')->load($id);

        if (!$product->getId()) {
            Mage::getSingleton('core/session')->addError($this->__('This product is not available'));
            return $this->_redirectReferer();
        }

        Mage::log(Mage::helper('lcb_pluxee')->__('customer %s tries to purchase product %s', $customer->getId(), $product->getId()), null, 'pluxee.log', true);
        Mage::dispatchEvent(
            'lcb_pluxee_purchase_before',
            array(
                'customer' => $customer,
                'product' => $product,
            )
        );

        $points = (float) $customer->getPluxeeCredit();
        $rewardPrice = (float) $product->getPrice();

        if ($points < $rewardPrice) {
            Mage::log(Mage::helper('lcb_pluxee')->__('customer %s not enough points for product %s', $customer->getId(), $product->getId()), null, 'pluxee.log', true);
            Mage::getSingleton('core/session')->addError($this->__('You have not enough points to obtain this reward'));
            return $this->_redirectReferer();
        }

        if ($userLimitDaily = Mage::helper('lcb_pluxee')->getUserLimitDaily()) {
            $purchasesCollection = Mage::getModel('lcb_pluxee/purchase')
                    ->getCollection()
                    ->addFieldToFilter('customer_id', $customer->getId())
                    ->addFieldToFilter('created_at', ['from' => date('Y-m-d H:i:s', strtotime('-24 hours', time()))]);
            $purchasesCollectionAmountValues = $purchasesCollection->getColumnValues('worth');
            $purchasesCollectionAmount = array_sum($purchasesCollectionAmountValues);
            if ($purchasesCollectionAmount > $userLimitDaily) {
                Mage::helper('lcb_pluxee')->log(Mage::helper('lcb_pluxee')->__('user daily limit exceeded'));
                Mage::getSingleton('core/session')->addError($this->__('Daily transaction limit exceeded'));
                return $this->_redirectReferer();
            }
        }

        if ($generalLimitDaily = Mage::helper('lcb_pluxee')->getGeneralLimitDaily()) {
            $purchasesCollection = Mage::getModel('lcb_pluxee/purchase')
                    ->getCollection()
                    ->addFieldToFilter('created_at', ['from' => date('Y-m-d H:i:s', strtotime('-24 hours', time()))]);
            $purchasesCollectionAmountValues = $purchasesCollection->getColumnValues('worth');
            $purchasesCollectionAmount = array_sum($purchasesCollectionAmountValues);
            if ($purchasesCollectionAmount > $generalLimitDaily) {
                Mage::helper('lcb_pluxee')->log(Mage::helper('lcb_pluxee')->__('general daily transaction limit exceeded'));
                Mage::getSingleton('core/session')->addError($this->__('Daily transaction limit exceeded'));
                return $this->_redirectReferer();
            }
        }

        $card = null;
        if ($cardNumber = $this->getRequest()->getParam('card_number')) {
            $card = new Varien_Object([
                'number' => $cardNumber,
                'amount' => $points,
            ]);
        }

        $order = Mage::getModel('lcb_pluxee/api')->purchase($customer, $product, $card);

        if (is_string($order)) {
            Mage::log($order, null, 'pluxee.log', true);
            Mage::getSingleton('core/session')->addError(Mage::helper('lcb_pluxee')->__($order));
            return $this->_redirectReferer();
        }

        if ($order->getId()) {
            Mage::log(Mage::helper('lcb_pluxee')->__('pluxee order %s', $order->getId()), null, 'order.log', true);
            Mage::dispatchEvent(
                'lcb_pluxee_purchase_after',
                array(
                    'customer' => $customer,
                    'product' => $product,
                    'order' => $order,
                )
            );

            Mage::getSingleton('customer/session')->setVoucherPurchaseId($order->getId());
            Mage::getSingleton('core/session')->addSuccess($this->__('Product purchased'));
        } else {
            Mage::getSingleton('core/session')->addError($this->__('Please try again later'));
        }

        $this->_redirectReferer();
    }
}
