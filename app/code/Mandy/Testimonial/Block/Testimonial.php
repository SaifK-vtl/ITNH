<?php
namespace Mandy\Testimonial\Block;

class Testimonial extends \Magento\Framework\View\Element\Template
{
    protected $_testimonialFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Mandy\Testimonial\Model\TestimonialFactory $testimonialFactory
    ) {
        $this->_testimonialFactory = $testimonialFactory;
        parent::__construct($context);
    }

    public function getTestimonialCollection()
    {
        $testimonial = $this->_testimonialFactory->create();
        return $testimonial->getCollection();
    }
}
