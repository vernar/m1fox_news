<?php

class Fox_News_Model extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        parent::_construct();
        $this->_init('fox/news');
    }
}