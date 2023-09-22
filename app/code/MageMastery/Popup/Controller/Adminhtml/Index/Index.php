<?php
namespace MageMastery\Popup\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends \Magento\Backend\App\Action
{


    // public function __construct(
    //    \Magento\Backend\App\Action\Context $context,
    //    \Magento\Framework\View\Result\PageFactory $pageFactory
    // )
    // {
    //     $this->_pageFactory = $pageFactory;
    //     return parent::__construct($context);
    // }

    public function execute() : ResultInterface
    {
         $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        //  $resultPage->getConfig()->getTitle()->prepend(__("Popups"));

         return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
