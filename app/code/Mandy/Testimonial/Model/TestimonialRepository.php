<?php
namespace Mandy\Testimonial\Model;

use Mandy\Testimonial\Api\TestimonialRepositoryInterface;
use Mandy\Testimonial\Api\Data;
use Mandy\Testimonial\Model\ResourceModel\Testimonial as ResourceTestimonial;
use Mandy\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory as TestimonialCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\HydratorInterface;

/**
 * Default block repo impl.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TestimonialRepository implements TestimonialRepositoryInterface
{
    /**
     * @var ResourceTestimonial
     */
    protected $resource;

    /**
     * @var estimonialFactory
     */
    protected $testimonialFactory;

    /**
     * @var TestimonialCollectionFactory
     */
    protected $testimonialCollectionFactory;

    /**
     * @var Data\TestimonialSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Mandy\Testimonial\Api\Data\TestimonialInterfaceFactory
     */
    protected $dataTestimonialFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param TestimonialBlock $resource
     * @param TestimonialFactory $testimonialFactory
     * @param Data\TestimonialInterfaceFactory $dataTestimonialFactory
     * @param TestimonialCollectionFactory $testimonialCollectionFactory
     * @param Data\TestimonialSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HydratorInterface|null $hydrator
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceTestimonial $resource,
        TestimonialFactory $testimonialFactory,
        \Mandy\Testimonial\Api\Data\TestimonialInterfaceFactory $dataTestimonialFactory,
        TestimonialCollectionFactory $testimonialCollectionFactory,
        Data\TestimonialSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null,
        HydratorInterface $hydrator = null
    ) {
        $this->resource = $resource;
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTestimonialFactory = $dataTestimonialFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->hydrator = $hydrator ?? ObjectManager::getInstance()->get(HydratorInterface::class);
    }

    /**
     * Save Block data
     *
     * @param \Mandy\Testimonial\Api\Data\TestimonialInterface $testimonial
     * @return Testimonial
     * @throws CouldNotSaveException
     */
    public function save(Data\TestimonialInterface $testimonial)
    {
        if (empty($testimonial->getStoreId())) {
            $testimonial->setStoreId($this->storeManager->getStore()->getId());
        }

        if ($testimonial->getId() && $testimonial instanceof Testimonial && !$testimonial->getOrigData()) {
            $testimonial = $this->hydrator->hydrate($this->getById($testimonial->getId()), $this->hydrator->extract($testimonial));
        }

        try {
            $this->resource->save($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $testimonial;
    }

    /**
     * Load Block data by given Block Identity
     *
     * @param string $testimonialId
     * @return Testimonial
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($testimonialId)
    {
        $testimonial = $this->testimonialFactory->create();
        $this->resource->load($testimonial, $testimonialId);
        if (!$testimonial->getId()) {
            throw new NoSuchEntityException(__('The CMS block with the "%1" ID doesn\'t exist.', $testimonialId));
        }
        return $testimonial;
    }

    /**
     * Load Block data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Mandy\Testimonial\Api\Data\TestimonialSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Mandy\Testimonial\Model\ResourceModel\Testimonial\Collection $collection */
        $collection = $this->testimonialCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\TestimonialSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Block
     *
     * @param \Mandy\Testimonial\Api\Data\TestimonialInterface $testimonial
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\TestimonialInterface $testimonial)
    {
        try {
            $this->resource->delete($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Block by given Block Identity
     *
     * @param string $testimonialId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($testimonialId)
    {
        return $this->delete($this->getById($testimonialId));
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 102.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        //phpcs:disable Magento2.PHP.LiteralNamespaces
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Magento\Cms\Model\Api\SearchCriteria\BlockCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}
