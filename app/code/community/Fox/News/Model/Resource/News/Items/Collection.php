<?php

class Fox_News_Model_Resource_News_Items_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    public function _construct()
    {
        parent::_construct();
        $this->_init('fox/news_items');
    }
}