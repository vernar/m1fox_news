<?php
class Fox_News_Block_Adminhtml_Foxnews_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('newsGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        /* @var $collection Fox_News_Model_Mysql4_Newslist_Collection */
        $collection = Mage::getModel('news/newslist')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'        => Mage::helper('news')->__('ID'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'id',
            'index'         => 'id'
        ));

        $this->addColumn('title', array(
            'header'        => Mage::helper('news')->__('Title'),
            'align'         => 'left',
            'filter_index'  => 'title',
            'index'         => 'title',
            'type'          => 'text',
            'width'         => 100,
            'truncate'      => 50,
            'escape'        => true,
        ));

        $this->addColumn('date', array(
            'header'        => Mage::helper('news')->__('Date'),
            'align'         => 'left',
            'index'         => 'date',
            'type'          => 'datetime',
            'escape'        => true,
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('news')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'sortable' =>false,
            'filter_condition_callback'
                => array($this, '_filterStatusCondition'),
            'options'   => array(
                Fox_News_Model_Newslist::STATUS_DISABLE => Mage::helper('news')->__('Disabled'),
                Fox_News_Model_Newslist::STATUS_ENABLE => Mage::helper('news')->__('Enabled')
            ),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('news')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('newsletter')->__('Action'),
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'width'	   => '170px',
                'renderer' => 'news/adminhtml_foxnews_template_grid_action'
        ));
        return parent::_prepareColumns();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    protected function _filterStatusCondition($collection, $column)
    {
        $this->getCollection()->addStatusFilter((int)$column->getFilter()->getValue());
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }


    public function getRowUrl($quote)
    {
        return $this->getUrl('*/foxnews/edit', array(
            'id' => $quote->getId(),
        ));
    }
}