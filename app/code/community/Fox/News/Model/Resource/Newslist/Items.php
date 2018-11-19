<?php

class Fox_News_Model_Resource_Newslist_Items extends Mage_Core_Model_Resource_Db_Abstract {

    public function _construct()
    {
        $this->_init('fox/newslist_items','id');
    }
}