<?php
namespace MageMastery\Popup\Model;

use MageMastery\Popup\Api\Data\PopupInterface;
use phpDocumentor\Reflection\Types\This;

class Popup extends \Magento\Framework\Model\AbstractModel implements PopupInterface
{

    protected function _construct()
    {
        $this->_eventPrefix = "magemastery_popup";
        $this->_eventObject = "popup";
        $this->_idFieldName = "popup_id";
        $this->_init('MageMastery\Popup\Model\ResourceModel\Popup');
    }

    public function getPopupId(): int {
        return (int) $this->getData("popup_id");
    }

    public function setPopupId(int $popupId) {
        $this->setData("popup_id", $popupId);
    }
    
    public function getName(): string {
        return (string) $this->getData("name");
    }

    public function setName(string $popupName){
        $this->setData("name", $popupName);
    }
    
    public function getContent(): string {
        return (string) $this->getData("content");
    }

    public function setContent(string $popupContent) {
        $this->setData("content", $popupContent);
    }

    public function getCreatedAt(): string {
        return (string) $this->getData("createdAt");
    }

    public function setCreateAt(string $createdAt) {
        $this->setData("createdAt", $createdAt);
    }

    public function getUpdatedAt(): string {
        return (string) $this->getData("updatedAt");
    }

    public function setUpdatedAt(string $updatedAt) {
        $this->setData("updatedAt", $updatedAt);
    }

    public function getTimeout(): int {
        return (int) $this->getData("timeout");
    }

    public function setTimeout(int $timeout) {
        $this->setData("timeout", $timeout);
    }

    public function getIsActive(): bool
    {
        return (bool) $this->setData('is_active');
    }

    public function setIsActive(bool $isActive) {
        $this->setData('is_active', $isActive);
    }
}
