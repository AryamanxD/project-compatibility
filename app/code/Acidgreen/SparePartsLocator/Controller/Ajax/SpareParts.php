<?php

namespace Acidgreen\SparePartsLocator\Controller\Ajax;

class Spareparts extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $productCollection;
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
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        \Magento\Catalog\Model\Product\Visibility $productVisibility
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->productCollection = $productCollection;
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
            $response = [];
            if (!empty($post)) {
                if(!empty($post['welding_helmet_series']) && empty($post['spare_part_type'])){
                    $weldingHelmetSeries = $post['welding_helmet_series'];
                    $products = $this->getProductsByWeldingHelmetSeries($weldingHelmetSeries);
                    $response['spare_part_type'][] = '<option selected disabled value="" >Select Spare Part Type</option>';
                    foreach($products as $product){
                        $option = "<option value='".$product->getSparePartType()."'>".$this->getOptionLabel($product, $product->getSparePartType(), 'spare_part_type')."</option>";
                        // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/AWS-341.log');
                        // $logger = new \Zend\Log\Logger();
                        // $logger->addWriter($writer);
                        // $logger->info($product->getName());
                        if(!in_array($option, $response['spare_part_type']) && $product->getSparePartType()){
                            $response['spare_part_type'][] = $option;
                        }
                    }
                }else if(!empty($post['spare_part_type']) && !empty($post['welding_helmet_series'])){
                    $sparePartType = $post['spare_part_type'];
                    $weldingHelmetSeries = $post['welding_helmet_series'];
                    $products = $this->getProductBySparePart($weldingHelmetSeries,$sparePartType);
                    $response['spare_part'][] = '<option selected disabled value="" >Select Spare Part</option>';
                    foreach($products as $product){
                        $option = "<option value='".$product->getId()."'>".$product->getName()."</option>";
                        if(!in_array($option, $response['spare_part'])){
                            $response['spare_part'][] = $option;
                        }
                    }
                }
            }else{
                $response['response'] = false;
            }
            return $this->jsonResponse($response);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
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

    private function getOptionLabel($product, $optionValue, $attributeCode){
        $attr = $product->getResource()->getAttribute($attributeCode);
        $optionText = '';
         if ($attr->usesSource()) {
               $optionText = $attr->getSource()->getOptionText($optionValue);
         }
         return $optionText;
    }

    private function getProductsByWeldingHelmetSeries($weldingHelmetSeries){
        $productCollection = $this->productCollection->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter(
            array(
                  array('attribute'=> 'welding_helmet_model', 'finset'=> $weldingHelmetSeries)
            )
        );
        $productCollection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $productCollection->setVisibility($this->productVisibility->getVisibleInSiteIds());

        return $productCollection->load();
    }

    private function getProductBySparePart($weldingHelmetSeries, $sparePartType){
        $productCollection = $this->productCollection->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter(
            array(
                  array('attribute'=> 'welding_helmet_model', 'finset'=> $weldingHelmetSeries)
            )
        );
        $productCollection->addAttributeToFilter('spare_part_type', $sparePartType);
        $productCollection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $productCollection->setVisibility($this->productVisibility->getVisibleInSiteIds());

        return $productCollection->load();
    }

}
