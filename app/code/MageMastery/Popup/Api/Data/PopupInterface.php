<?php
namespace MageMastery\Popup\Api\Data;

interface PopupInterface
{
    public function getPopupId(): int;
    public function setPopupId(int $popupId);
    
    public function getName(): string;
    public function setName(string $popupName);
    
    public function getContent(): string;
    public function setContent(string $popupContent);

    public function getCreatedAt(): string;
    public function setCreateAt(string $createdAt);

    public function getUpdatedAt(): string;
    public function setUpdatedAt(string $updatedAt);

    public function getTimeout(): int;
    public function setTimeout(int $timeout);

    public function getIsActive(): bool;
    public function setIsActive(bool $isActive);
}