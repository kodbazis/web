<?php

namespace Kodbazis\Generated\Course\Patch;

use JsonSerializable;

class PatchedCourse implements JsonSerializable
{
    private $title;
private $invoiceTitle;
private $content;
private $slug;
private $imgUrl;
private $videoId;
private $description;
private $isActive;
private $price;
private $discount;


    
public function __construct($title, $invoiceTitle, $content, $slug, $imgUrl, $videoId, $description, $isActive, $price, $discount)
{
        $this->title = $title;
$this->invoiceTitle = $invoiceTitle;
$this->content = $content;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->videoId = $videoId;
$this->description = $description;
$this->isActive = $isActive;
$this->price = $price;
$this->discount = $discount;

}
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getInvoiceTitle(): ?string
    {
        return $this->invoiceTitle;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }
    public function getPrice(): ?int
    {
        return $this->price;
    }
    public function getDiscount(): ?int
    {
        return $this->discount;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
 'invoiceTitle' => $this->invoiceTitle,
 'content' => $this->content,
 'slug' => $this->slug,
 'imgUrl' => $this->imgUrl,
 'videoId' => $this->videoId,
 'description' => $this->description,
 'isActive' => $this->isActive,
 'price' => $this->price,
 'discount' => $this->discount,

        ];
    }
}
