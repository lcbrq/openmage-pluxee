<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Adminhtml_AdminPluxeeLogController extends Mage_Adminhtml_Controller_Action
{
    public const ADMIN_RESOURCE = 'pluxee/logs';

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('pluxee/logs');
        $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_log_grid'));
        $this->renderLayout();
    }

    /**
     * Export log grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'pluxee_api_logs.csv';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_log_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export log grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'pluxee_api_logs.xml';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_log_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
