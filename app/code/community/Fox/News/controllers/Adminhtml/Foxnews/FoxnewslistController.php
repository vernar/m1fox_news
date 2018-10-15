<?php

class Fox_News_Adminhtml_Foxnews_FoxnewslistController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('foxnews/foxnewslist');
    }

//    protected function _initAction()
//    {
//        $this->_title($this->__('Site News - List'));
//
//        $this->loadLayout()
//            ->_setActiveMenu('foxnews')
//        ;
//        return $this;
//    }

    public function indexAction()
    {
        die("list index");
    }

}