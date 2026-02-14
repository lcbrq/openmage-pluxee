<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Adminhtml_AdminPluxeeOrderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('pluxee/orders');
    }

    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('pluxee/orders')->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
        return $this;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_order_grid'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__('lcb_pluxee'));
        $this->_title($this->__('Purchase'));
        $this->_title($this->__('View'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('lcb_pluxee/order')->load($id);
        if ($model->getId()) {
            if ($pin = $model->getPin()) {
                $model->setPin(preg_replace("/(^.|.$)(*SKIP)(*F)|(.)/", "*", $pin)); // obscure
            }
            Mage::register('order_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('lcb_pluxee/orders');
            $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_order_edit'))->_addLeft($this->getLayout()->createBlock('lcb_pluxee/adminhtml_order_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('lcb_pluxee')->__('Item does not exist.'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'pluxee_orders.csv';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'pluxee_orders.xml';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
