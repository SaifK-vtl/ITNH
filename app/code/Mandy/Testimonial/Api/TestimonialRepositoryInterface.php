<?php
namespace Mandy\Testimonial\Api;

/**
 * CMS block CRUD interface.
 * @api
 * @since 100.0.2
 */
interface TestimonialRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Mandy\Testimonial\Api\Data\TestimonialInterface $testimonial
     * @return \Mandy\Testimonial\Api\Data\TestimonialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\TestimonialInterface $testimonial);

    /**
     * Retrieve block.
     *
     * @param string $testimonialId
     * @return \Mandy\Testimonial\Api\Data\TestimonialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($testimonialId);

    /**
     * Retrieve blocks matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mandy\Testimonial\Api\Data\TestimonialSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete block.
     *
     * @param \Mandy\Testimonial\Api\Data\TestimonialInterface $testimonial
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\TestimonialInterface $testimonial);

    /**
     * Delete block by ID.
     *
     * @param string $testimonialId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($testimonialId);
}
