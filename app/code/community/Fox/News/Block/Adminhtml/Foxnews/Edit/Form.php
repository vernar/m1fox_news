<?php

class Fox_News_Block_Adminhtml_Foxnews_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve news object
     *
     * @return Fox_News_Model_Newslist
     */
    public function getModel()
    {
        return Mage::registry('current_news');
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Fox_News_Block_Adminhtml_Foxnews_Edit_Form
     */
    protected function _prepareForm()
    {
        $model  = $this->getModel();
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('news')->__('General'),
            'class'     => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'value'     => $model->getId(),
            ));
        }

        $fieldset->addField('title', 'text', array(
        'name'      => 'title',
        'label'     => Mage::helper('news')->__('News Title'),
        'title'     => Mage::helper('news')->__('News Title'),
        'required'  => true,
        'value'     => $model->getTitle(),
        ));

        $fieldset->addField('status', 'select', array(
            'name'      => 'status',
            'label'     => Mage::helper('news')->__('Status'),
            'title'     => Mage::helper('news')->__('Status'),
            'required'  => false,
            'value'     => $model->getStatus(),
            'options'   => array(
                Fox_News_Model_Newslist::STATUS_DISABLE => Mage::helper('news')->__('Disabled'),
                Fox_News_Model_Newslist::STATUS_ENABLE => Mage::helper('news')->__('Enabled')
            ),
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );
        $fieldset->addField('date', 'date', array(
            'name'      => 'date',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('news')->__('Date'),
            'title'     => Mage::helper('news')->__('Date'),
            'required'  => true,
            'value'     => $model->getDate(),
        ));

        $fieldset->addField('store_id', 'multiselect', array(
            'name'      => 'stores[]',
            'label'     => Mage::helper('news')->__('Store'),
            'title'     => Mage::helper('news')->__('Store'),
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            'required'  => true,
            'value'     => $model->getStoreId(),
        ));

        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
