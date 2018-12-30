<?php

class Fox_News_Model_Newslist extends Mage_Core_Model_Abstract {
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public function _construct()
    {
        parent::_construct();
        $this->_init('news/newslist');
    }
}