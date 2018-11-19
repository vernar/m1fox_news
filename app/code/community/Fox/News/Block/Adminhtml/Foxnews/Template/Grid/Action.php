<?php

class Fox_News_Block_Adminhtml_Foxnews_Template_Grid_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{

    public function render(Varien_Object $row)
    {
        $actions[] = array(
            'url'     => $this->getUrl('*/foxnews/edit', array('id'=>$row->getId())),
            'popup'   => false,
            'caption' => Mage::helper('news')->__('Edit')
        );

        $actions[] = array(
            'url'     => $this->getUrl('*/foxnews/delete', array('id'=>$row->getId())),
            'popup'   => false,
            'caption' => Mage::helper('news')->__('Delete')
        );

        $this->getColumn()->setActions($actions);

        return parent::render($row);
    }
}
