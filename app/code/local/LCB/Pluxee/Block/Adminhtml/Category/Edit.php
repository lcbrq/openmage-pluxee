<?php

class LCB_Pluxee_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'lcb_pluxee';
        $this->_controller = 'adminhtml_category';
        $this->_updateButton('save', 'label', Mage::helper('lcb_pluxee')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('lcb_pluxee')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('lcb_pluxee')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }";
    }

    public function getHeaderText()
    {
        if (Mage::registry('category_data') && Mage::registry('category_data')->getId()) {
            return Mage::helper('lcb_pluxee')->__("Edit Category '%s'", $this->escapeHtml(Mage::registry('category_data')->getLabel()));
        }

        return Mage::helper('lcb_pluxee')->__('Add');
    }
}
