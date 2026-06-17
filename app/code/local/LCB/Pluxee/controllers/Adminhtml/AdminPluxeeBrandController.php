<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Adminhtml_AdminPluxeeBrandController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @inheritDoc
     */
    public const ADMIN_RESOURCE = 'pluxee/brands';

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('pluxee/brands')
            ->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Brands Manager'),
                Mage::helper('adminhtml')->__('Brands Manager')
            );

        return $this;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__('Pluxee'));
        $this->_title($this->__('Edit Brand'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('lcb_pluxee/brand')->load($id);
        if ($model->getId()) {
            Mage::register('brand_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('pluxee/brands');
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Brands Manager'),
                Mage::helper('adminhtml')->__('Brands Manager')
            );
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Brand Description'),
                Mage::helper('adminhtml')->__('Brand Description')
            );
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_edit'))
                ->_addLeft($this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('lcb_pluxee')->__('Item does not exist.'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_title($this->__('lcb_pluxee'));
        $this->_title($this->__('Brands'));
        $this->_title($this->__('New Item'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('lcb_pluxee/brand')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('brand_data', $model);

        $this->loadLayout();
        $this->_setActiveMenu('pluxee/brands');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addBreadcrumb(
            Mage::helper('adminhtml')->__('Brands Manager'),
            Mage::helper('adminhtml')->__('Brands Manager')
        );

        $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_edit'))
            ->_addLeft($this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_edit_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        if ($postData) {
            try {
                if ($this->getRequest()->getParam('id')) {
                    $model = Mage::getModel('lcb_pluxee/brand')->load($this->getRequest()->getParam('id'));
                } else {
                    $model = Mage::getModel('lcb_pluxee/brand');
                }

                $model->addData($postData)
                    ->setId($this->getRequest()->getParam('id'))
                    ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Brand was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setBrandData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBrandData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('lcb_pluxee/brand');
                $model->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Item was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/');
    }

    public function massRemoveAction()
    {
        try {
            $ids = $this->getRequest()->getPost('ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel('lcb_pluxee/brand');
                $model->setId($id)->delete();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Item(s) was successfully removed')
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*/');
    }

    /**
     * Export brand grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'pluxee_brand.csv';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export brand grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'pluxee_brand.xml';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_brand_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
