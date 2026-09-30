<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Block_Adminhtml_Log_View_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return LCB_Pluxee_Block_Adminhtml_Log_View_Form
     * @throws Exception
     */
    protected function _prepareForm()
    {
        $log = Mage::getModel('lcb_pluxee/log')->load($this->getRequest()->getParam('id'));

        if ($request = $log->getRequest()) {
            $requestJsonObject = json_decode($request);
            $requestJsonString = json_encode($requestJsonObject, JSON_PRETTY_PRINT);
        }

        if ($response = $log->getResponse()) {
            $responseJsonObject = json_decode($response);
            $responseJsonString = json_encode($responseJsonObject, JSON_PRETTY_PRINT);
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/'),
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $this->__('Information'),
            'class' => 'fieldset-wide',
        ));

        $fieldset->addField(
            'method',
            'text',
            array(
                'name' => 'method',
                'label' => $this->__('Method'),
                'title' => $this->__('Method'),
                'readonly' => true,
                'value' => $log->getMethod(),
            )
        );

        $fieldset->addField(
            'path',
            'text',
            array(
                'name' => 'path',
                'label' => $this->__('Path'),
                'title' => $this->__('Path'),
                'readonly' => true,
                'value' => $log->getPath(),
            )
        );

        $fieldset->addField(
            'status',
            'text',
            array(
                'name' => 'status',
                'label' => $this->__('Status'),
                'title' => $this->__('Status'),
                'readonly' => true,
                'value' => $log->getStatus(),
            )
        );

        $fieldset->addField(
            'request',
            'textarea',
            array(
                'name' => 'request',
                'label' => $this->__('Request'),
                'title' => $this->__('Request'),
                'readonly' => true,
                'value' => $requestJsonString ?? '',
            )
        );

        $fieldset->addField(
            'response',
            'textarea',
            array(
                'name' => 'response',
                'label' => $this->__('Response'),
                'title' => $this->__('Response'),
                'readonly' => true,
                'value' => $responseJsonString ?? '',
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
                'value' => $log->getCreatedAt(),
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
