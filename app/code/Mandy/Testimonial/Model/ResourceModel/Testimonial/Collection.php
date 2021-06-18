<?php
namespace Mandy\Testimonial\Model\ResourceModel\Testimonial;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'tsm_id';
    protected $_eventPrefix = 'testimonial_testimonial_collection';
    protected $_eventObject = 'testimonial_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mandy\Testimonial\Model\Testimonial', 'Mandy\Testimonial\Model\ResourceModel\Testimonial');
    }

}

