<?php

/**
 * Empty form shell rendered in the main content area; the actual tab
 * contents are injected into it client-side by the left Tabs widget
 * (see LCB_Pluxee_Block_Adminhtml_Order_View_Tabs::setDestElementId()).
 *
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Order_View_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/'),
            'method' => 'post',
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
