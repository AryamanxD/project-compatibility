<?php


namespace Acidgreen\SparePartsLocator\Controller\Sparepartfindertool;

class Submit extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $product;
    protected $messageManager;
    protected $productStatus;
    protected $productVisibility;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Catalog\Model\ProductRepository $product,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        \Magento\Catalog\Model\Product\Visibility $productVisibility
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->product = $product;
        $this->messageManager = $messageManager;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $post = (array) $this->getRequest()->getPost();
            if (!empty($post)) {
                if(!empty($post['part_number'])){
                    $partNumber = $post['part_number'];
                    $product = $this->getProductBySku($partNumber);

                }else if(!empty($post['spare_part'])){
                    $productId = $post['spare_part'];
                    $product = $this->getProductById($productId);
                }
                return $this->_redirect($product->getProductUrl());
            }else{
                $this->messageManager->addError($e->getMessage());
                return $this->_redirect($this->_redirect->getRefererUrl());
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError("Sorry the part you entered is not a current Speedglas part, please try again");
            return $this->_redirect($this->_redirect->getRefererUrl());
        } catch (\Exception $e) {
            // $this->logger->critical($e);
            $this->messageManager->addError($e->getMessage());
            return $this->_redirect($this->_redirect->getRefererUrl());
        }
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }

    private function getProductById($id)
    {
        return $this->product->getById($id);
    }
    
    private function getProductBySku($sku)
    {
        return $this->product->get($sku);
    }
}
