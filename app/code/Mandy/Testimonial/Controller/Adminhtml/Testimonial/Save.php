<?php
namespace Mandy\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;
    protected $testimonialFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Mandy\Testimonial\Model\TestimonialFactory $testimonialFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->_testimonialFactory = $testimonialFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            $id = $this->getRequest()->getParam('tsm_id');
            $model = $this->_objectManager->create(\Mandy\Testimonial\Model\Testimonial::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This testimonial no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $data = $this->_filterAttachmentData($data);
            $data['image'] = json_encode($data['image']);
            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the testimonial.'));
                $this->dataPersistor->clear('mandy_testimonial_testimonial');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['tsm_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the quote.'));
            }

            $this->dataPersistor->set('mandy_testimonial_testimonial', $data);
            return $resultRedirect->setPath('*/*/edit', ['tsm_id' => $this->getRequest()->getParam('tsm_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _filterAttachmentData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
}
