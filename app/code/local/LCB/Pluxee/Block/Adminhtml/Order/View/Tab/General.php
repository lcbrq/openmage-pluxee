<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Order_View_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return LCB_Pluxee_Block_Adminhtml_Order_View_Tab_General
     * @throws Exception
     */
    protected function _prepareForm()
    {
        $order = Mage::registry('order_data');

        $form = new Varien_Data_Form(array(
            'id' => 'order_general_form',
            'action' => $this->getUrl('*/*/'),
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $this->__('General Information'),
            'class' => 'fieldset-wide',
        ));

        $fieldset->addField(
            'entity_id',
            'text',
            array(
                'name' => 'entity_id',
                'label' => $this->__('ID'),
                'title' => $this->__('ID'),
                'readonly' => true,
                'value' => $order->getId(),
            )
        );

        $fieldset->addField(
            'order_id',
            'text',
            array(
                'name' => 'order_id',
                'label' => $this->__('Pluxee Order ID'),
                'title' => $this->__('Pluxee Order ID'),
                'readonly' => true,
                'value' => $order->getOrderId(),
            )
        );

        $fieldset->addField(
            'customer_id',
            'text',
            array(
                'name' => 'customer_id',
                'label' => $this->__('Customer ID'),
                'title' => $this->__('Customer ID'),
                'readonly' => true,
                'value' => $order->getCustomerId(),
            )
        );

        $fieldset->addField(
            'grand_total',
            'text',
            array(
                'name' => 'grand_total',
                'label' => $this->__('Total'),
                'title' => $this->__('Total'),
                'readonly' => true,
                'value' => $order->getGrandTotal(),
            )
        );

        $fieldset->addField(
            'serial',
            'text',
            array(
                'name' => 'serial',
                'label' => $this->__('Serial'),
                'title' => $this->__('Serial'),
                'readonly' => true,
                'value' => $order->getSerial(),
            )
        );

        $fieldset->addField(
            'pin',
            'text',
            array(
                'name' => 'pin',
                'label' => $this->__('PIN'),
                'title' => $this->__('PIN'),
                'readonly' => true,
                'value' => $order->getPin(),
            )
        );

        $fieldset->addField(
            'expires',
            'text',
            array(
                'name' => 'expires',
                'label' => $this->__('Expires'),
                'title' => $this->__('Expires'),
                'readonly' => true,
                'value' => $order->getExpires(),
            )
        );

        $fieldset->addField(
            'created_at',
            'text',
            array(
                'name' => 'created_at',
                'label' => $this->__('Created At'),
                'title' => $this->__('Created At'),
                'readonly' => true,
                'value' => $order->getCreatedAt(),
            )
        );

        $fieldset->addField(
            'updated_at',
            'text',
            array(
                'name' => 'updated_at',
                'label' => $this->__('Updated At'),
                'title' => $this->__('Updated At'),
                'readonly' => true,
                'value' => $order->getUpdatedAt(),
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
