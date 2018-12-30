<?php

class Fox_News_Block_Adminhtml_Foxnews extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'news';
        $this->_controller = 'adminhtml_foxnews';

        $this->_addButtonLabel = Mage::helper('news')->__('Add new News');
        $this->_headerText = Mage::helper('news')->__('News List');
    }
}