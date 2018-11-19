<?php

class Fox_News_CustomerController extends Mage_Core_Controller_Front_Action {

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('News'));
        if ($block = $this->getLayout()->getBlock('fox_news.customer.container')) {
            $block->setRefererUrl($this->_getRefererUrl());
        }

        $this->renderLayout();
    }
}