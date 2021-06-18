<?php
namespace Mandy\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Mandy\Testimonial\Model\Testimonial;

class Delete extends Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('tsm_id');

        if (!($contact = $this->_objectManager->create(Testimonial::class)->load($id))) {
            $this->messageManager->addErrorMessage(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }
        try {
            $contact->delete();
            $this->messageManager->addSuccessMessage(__('Your testimonial has been deleted !'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete testimonial: '));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
