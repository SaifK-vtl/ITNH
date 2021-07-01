<?php
namespace Mandy\Testimonial\Model;

use Mandy\Testimonial\Api\Data\TestimonialInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validator\HTML\WYSIWYGValidatorInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Testimonial  model
 *
 * @method Testimonial setStoreId(int $storeId)
 * @method int getStoreId()
 */
class Testimonial extends AbstractModel implements TestimonialInterface, IdentityInterface
{
    /**
     * Testimonial  cache tag
     */
    const CACHE_TAG = 'mandy_testimonial';

    /**#@+
     * Testimonial's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**#@-*/

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'mandy_testimonial';

    /**
     * @var WYSIWYGValidatorInterface
     */
    private $wysiwygValidator;
    /**
     *
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param WYSIWYGValidatorInterface|null $wysiwygValidator
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        ?WYSIWYGValidatorInterface $wysiwygValidator = null,
        StoreManagerInterface $storeManager

    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->wysiwygValidator = $wysiwygValidator
            ?? ObjectManager::getInstance()->get(WYSIWYGValidatorInterface::class);
        $this->storeManager = $storeManager;
    }

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mandy\Testimonial\Model\ResourceModel\Testimonial::class);
    }


    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Retrieve testimonial id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::TESTIMONIAL_ID);
    }

    /**
     * Retrieve testimonial identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string)$this->getData(self::IDENTIFIER);
    }

    /**
     * Retrieve testimonial title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Retrieve testimonial content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Retrieve testimonial image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Retrieve testimonial image
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }
    /**
     * Retrieve testimonial creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve testimonial update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function getStatus()
    {
        return (bool)$this->getData(self::STATUS);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return TestimonialInterface
     */
    public function setId($id)
    {
        return $this->setData(self::TESTIMONIAL_ID, $id);
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return TestimonialInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return TestimonialInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return TestimonialInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }
    /**
     * Set description
     *
     * @param string $description
     * @return TestimonialInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
    /**
     * Set description
     *
     * @param string $image
     * @return TestimonialInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
    /**
     * Set description
     *
     * @param string $position
     * @return TestimonialInterface
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }
    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return TestimonialInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return TestimonialInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $status
     * @return TestimonialInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Retrieve Base files path
     *
     * @return string
     */
    public function getBasePath()
    {
        return 'itnh/testimonial';
    }

    /**
     * @param string $image
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTestimonialImage($image = '')
    {
        $url        =   false;
        $fileName   =   !empty($image) ? $image : $this->getImage();

        $store = $this->storeManager->getStore();
        $mediaBaseUrl = $store->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        );

        $url = $mediaBaseUrl
            . ltrim($this->getBasePath(), '/')
            . '/'
            . $fileName;
        return $url;
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    /**
     * Prepare block's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
