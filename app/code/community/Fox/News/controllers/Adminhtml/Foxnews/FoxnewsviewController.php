<?php

class Fox_News_Adminhtml_Foxnews_FoxnewsviewController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('foxnews/foxnewsview');
    }

//    protected function _initAction()
//    {
//        $this->_title($this->__('Site News - View'));
//        $this->loadLayout()
//            ->_setActiveMenu('foxnews')
//        ;
//        return $this;
//    }

    public function indexAction()
    {
        die("view index");
    }

    public function addAction()
    {
        die("view_add index");
    }

}