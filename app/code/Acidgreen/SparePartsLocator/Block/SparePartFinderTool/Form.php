<?php


namespace Acidgreen\SparePartsLocator\Block\SparePartFinderTool;

class Form extends \Magento\Framework\View\Element\Template
{
    protected $eavConfig;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Eav\Model\Config $eavConfig,
        array $data = []
    ) {
        $this->eavConfig = $eavConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getWeldingHelmetSeries()
    {
        $attribute = $this->eavConfig->getAttribute('catalog_product', 'welding_helmet_model');
        $options = $attribute->getSource()->getAllOptions();
        if($options){
            return $options;
        }
        return false;
    }

    public function getFormUrl(){
        return $this->_storeManager->getStore()->getUrl('acidgreen_sparepartslocator/sparepartfindertool/submit');
    }
}
