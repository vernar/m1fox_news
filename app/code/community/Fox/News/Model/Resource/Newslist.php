<?php

class Fox_News_Model_Resource_Newslist extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct()
    {
        $this->_init('news/newslist','id');
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);

            $status = $this->lookupStatusId($object->getId());
            $object->setData('status', $status[0]);
        }
        return parent::_afterLoad($object);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($newsId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('news/newslist_items'), 'store_id')
            ->where('news_item_id = ?',(int)$newsId);

        return $adapter->fetchCol($select);
    }

    /**
     * Get status to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStatusId($newsId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('news/newslist_items'), 'status')
            ->where('news_item_id = ?',(int)$newsId)
            ->limit(1);

        return $adapter->fetchCol($select);
    }

    /**
     * Assign page to store views
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Fox_News_Model_Resource_Newslist
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('news/newslist_items');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'news_item_id = ?'     => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'news_item_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);

        }
        $this->_getWriteAdapter()->update(
            $table,
            array('status'  => (int) $object->getStatus() ),
            array('news_item_id = ?' => (int) $object->getId() )
        );

        return parent::_afterSave($object);
    }
}