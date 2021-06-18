<?php
namespace Mandy\Testimonial\Api\Data;

/**
 * CMS block interface.
 * @api
 * @since 100.0.2
 */
interface TestimonialInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TESTIMONIAL_ID      = 'tsm_id';
    const IDENTIFIER    = 'identifier';
    const TITLE         = 'title';
    const DESCRIPTION   = 'description';
    const CONTENT       = 'content';
    const IMAGE         = 'image';
    const POSITION      = 'position';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const STATUS        = 'status';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Get position
     *
     * @return string|null
     */
    public function getPosition();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function getStatus();

    /**
     * Set ID
     *
     * @param int $id
     * @return TestimonialInterface
     */
    public function setId($id);

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return TestimonialInterface
     */
    public function setIdentifier($identifier);

    /**
     * Set title
     *
     * @param string $title
     * @return TestimonialInterface
     */
    public function setTitle($title);

    /**
     * Set description
     *
     * @param string $description
     * @return TestimonialInterface
     */
    public function setDescription($description);

    /**
     * Set content
     *
     * @param string $content
     * @return TestimonialInterface
     */
    public function setContent($content);

    /**
     * Set image
     *
     * @param string $image
     * @return TestimonialInterface
     */
    public function setImage($image);

    /**
     * Set position
     *
     * @param string $position
     * @return TestimonialInterface
     */
    public function setPosition($position);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return TestimonialInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return TestimonialInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param bool|int $status
     * @return TestimonialInterface
     */
    public function setStatus($status);
}
