<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'lcb_pluxee';

        $this->_headerText = Mage::helper('lcb_pluxee')->__('Pluxee Categories');
        $this->_addButtonLabel = Mage::helper('lcb_pluxee')->__('Add');
        parent::__construct();
    }
}
