<?php

class Fox_News_Block_Adminhtml_Foxnews_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'news';
        $this->_controller = 'adminhtml_foxnews';

        parent::__construct();

        $this->_removeButton('reset');
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        $quote = Mage::registry('current_news');
        if ($quote->getId()) {
            return Mage::helper('news')->__("Edit News '%s'", $this->escapeHtml($quote->getTitle()));
        } else {
            return Mage::helper('news')->__("Add new News");
        }
    }
}

