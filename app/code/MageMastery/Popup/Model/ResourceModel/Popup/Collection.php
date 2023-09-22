<?php
namespace MageMastery\Popup\Model\ResourceModel\Popup;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'popup_id';
    protected $_eventPrefix = 'magemastery_popup_popup_collection';
    protected $_eventObject = 'popup_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MageMastery\Popup\Model\Popup', 'MageMastery\Popup\Model\ResourceModel\Popup');
    }
}
