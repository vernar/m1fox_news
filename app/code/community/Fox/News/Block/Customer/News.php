<?php

class Fox_News_Block_Customer_News extends Mage_Core_Block_Template
{
    protected $_collection;

    /**
     * @return Fox_News_Model_Resource_Newslist_Collection
     */
    public function getCollection()
    {
        if (!$this->_collection) {
            /** @var Fox_News_Model_Resource_Newslist_Collection $collection */
            $collection = Mage::getModel('news/newslist')->getCollection();
            $this->_collection = $collection->getFilteredData();
        }
        return $this->_collection;
    }

    public function getFormatDate($stringDate)
    {
        $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($stringDate));
        return date('d/m/y', $dateTimestamp);
    }

    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('customer/account/');
    }

}