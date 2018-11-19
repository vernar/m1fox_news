<?php

class Fox_News_Model_Resource_Newslist_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    public function _construct()
    {
        parent::_construct();
        $this->_init('news/newslist');
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Fox_News_Model_Resource_Newslist_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->getSelect()
            ->distinct()
            ->join(
                array('items_table' => $this->getTable('newslist_items')),
                'main_table.id = items_table.news_item_id',
                array()
            )
            ->where('items_table.store_id = ?', (int)$store);
        return $this;
    }

    /**
     * Add filter by status
     *
     * @param int
     * @param bool $withAdmin
     * @return Fox_News_Model_Resource_Newslist_Collection
     */
    public function addStatusFilter($status, $withAdmin = true)
    {
         $this->getSelect()
                ->distinct()
                ->join(
                    array('items_table' => $this->getTable('newslist_items')),
                    'main_table.id = items_table.news_item_id',
                    array()
                )
                ->where('items_table.status = ?', (int)$status);
        return $this;
    }
}