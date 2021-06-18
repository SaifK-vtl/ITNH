<?php
namespace Mandy\Testimonial\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms block search results.
 * @api
 * @since 100.0.2
 */
interface TestimonialSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blocks list.
     *
     * @return \Mandy\Testimonial\Api\Data\TestimonialInterface[]
     */
    public function getItems();

    /**
     * Set blocks list.
     *
     * @param \Mandy\Testimonial\Api\Data\TestimonialInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
