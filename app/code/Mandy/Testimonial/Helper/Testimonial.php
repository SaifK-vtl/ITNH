<?php

namespace Mandy\Testimonial\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Testimonial extends AbstractHelper
{
    const XML_PATH_TESTIMONIAL = 'testimonial/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_TESTIMONIAL . 'options/' . $code, $storeId);
    }
}
