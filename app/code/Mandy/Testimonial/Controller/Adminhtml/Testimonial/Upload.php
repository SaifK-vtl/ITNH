<?php
namespace Mandy\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\ImageUploader;

class Upload extends \Magento\Backend\App\Action
{
    /**
     * @var ImageUploader
     */
    public $imageUploader;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Mandy\Testimonial\Helper\Testimonial
     */
    protected $testimonialData;

    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Mandy\Testimonial\Helper\Testimonial $testimonialData
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mandy\Testimonial\Helper\Testimonial $testimonialData
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->resultPageFactory = $resultPageFactory;
        $this->testimonialData = $testimonialData;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
