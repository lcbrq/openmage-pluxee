<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Adminhtml_AdminPluxeeCardController extends Mage_Adminhtml_Controller_Action
{
    public const ADMIN_RESOURCE = 'pluxee/cards';

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('pluxee/cards');
        $this->_addContent($this->getLayout()->createBlock('lcb_pluxee/adminhtml_card_grid'));
        $this->renderLayout();
    }

    /**
     * Export card grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'pluxee_cards.csv';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_card_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export card grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'pluxee_cards.xml';
        $grid = $this->getLayout()->createBlock('lcb_pluxee/adminhtml_card_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
