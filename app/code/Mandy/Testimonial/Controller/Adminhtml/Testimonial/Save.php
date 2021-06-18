<?php
namespace Mandy\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Mandy\Testimonial\Api\TestimonialRepositoryInterface;
use Mandy\Testimonial\Model\Testimonial;
use Mandy\Testimonial\Model\TestimonialFactory;

/**
 * Save CMS block action.
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var TestimonialFactory
     */
    private $testimonialFactory;

    /**
     * @var TestimonialRepositoryInterface
     */
    private $testimonialRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param TestimonialFactory|null $testimonialFactory
     * @param TestimonialRepositoryInterface|null $testimonialRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        TestimonialFactory $testimonialFactory = null,
        TestimonialRepositoryInterface $testimonialRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->testimonialFactory = $testimonialFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(TestimonialFactory::class);
        $this->testimonialRepository = $testimonialRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(TestimonialRepositoryInterface::class);
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Testimonial::STATUS_ENABLED;
            }
            if (empty($data['tsm_id'])) {
                $data['tsm_id'] = null;
            }

            /** @var \Mandy\Testimonial\Model\Testimonial $model */
            $model = $this->testimonialFactory->create();

            $id = $this->getRequest()->getParam('tsm_id');
            if ($id) {
                try {
                    $model = $this->testimonialRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This testimonial no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->testimonialRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the testimonial.'));
                $this->dataPersistor->clear('testimonial');
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the testimonial.'));
            }

            $this->dataPersistor->set('testimonial', $data);
            return $resultRedirect->setPath('*/*/edit', ['tsm_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param \Mandy\Testimonial\Model\Testimonial $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['tsm_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->testimonialFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel->setIdentifier($data['identifier'] . '-' . uniqid());
            $duplicateModel->setStatus(Testimonial::STATUS_DISABLED);
            $this->testimonialRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the testimonial.'));
            $this->dataPersistor->set('testimonial', $data);
            $resultRedirect->setPath('*/*/edit', ['tsm_id' => $id]);
        }
        return $resultRedirect;
    }
}
