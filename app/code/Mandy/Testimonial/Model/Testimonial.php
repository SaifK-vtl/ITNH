<?php
namespace Mandy\Testimonial\Model;
class Testimonial extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'mandy_testimonial_testimonial';

    protected $_cacheTag = 'mandy_testimonial_testimonial';

    protected $_eventPrefix = 'mandy_testimonial_testimonial';

    protected function _construct()
    {
        $this->_init('Mandy\Testimonial\Model\ResourceModel\Testimonial');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
