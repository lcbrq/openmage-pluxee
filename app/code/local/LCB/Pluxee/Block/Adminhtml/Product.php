<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'lcb_pluxee';

        $this->_headerText = Mage::helper('lcb_pluxee')->__('Pluxee');
        $this->_addButtonLabel = Mage::helper('lcb_pluxee')->__('Add');
        parent::__construct();

        $this->_addButton('import', array(
            'label' => Mage::helper('lcb_pluxee')->__('Import %s', 'CSV'),
            'onclick' => "$('importProductsCsv').click();",
            'class' => 'btn btn-danger',
        ));
    }

    /**
     * Produce buttons HTML
     *
     * @param string $area
     * @return string
     */
    public function getButtonsHtml($area = null)
    {
        $html = parent::getButtonsHtml($area);
        $importFileUploadUrl = $this->getUrl('*/*/uploadCsv');
        $formKey = $this->getFormKey();
        $html .=  <<< EOT
            <form enctype="multipart/form-data" method="post" action="$importFileUploadUrl">
                <input name="form_key" type="hidden" value="$formKey" />
                <input id="importProductsCsv" accept=".csv" name="productsCsv" type="file" onchange="form.submit()" style="display: none">
            </form>
EOT;
        return $html;
    }
}
