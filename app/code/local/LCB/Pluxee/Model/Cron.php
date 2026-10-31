<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Model_Cron
{
    /**
     * Fetch Pluxee order statuses for orders whose cached status is missing
     * or stale (older than 15 minutes but not older than one month).
     *
     * @return void
     */
    public function fetchOrderStatuses()
    {
        if (!Mage::getStoreConfigFlag('pluxee/order/get_states_from_cron')) {
            return;
        }

        $fifteenMinutesAgo = date(Varien_Date::DATETIME_PHP_FORMAT, strtotime('-15 minutes'));
        $oneMonthAgo = date(Varien_Date::DATETIME_PHP_FORMAT, strtotime('-1 month'));

        $collection = Mage::getModel('lcb_pluxee/order')->getCollection();
        $adapter = $collection->getConnection();
        $collection->getSelect()->where(sprintf(
            'status IS NULL OR (updated_at < %s AND updated_at > %s)',
            $adapter->quote($fifteenMinutesAgo),
            $adapter->quote($oneMonthAgo)
        ));

        $api = Mage::getModel('lcb_pluxee/api');

        foreach ($collection as $order) {
            $id = $order->getIncrementId() ?: $order->getSerial();
            if (!$id) {
                continue;
            }

            try {
                $result = $api->getOrder($id);
                if (isset($result['Response']['status']['label'])) {
                    $order->setStatus('PLUXEE_' . $result['Response']['status']['label'])->save();
                }
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }
}
