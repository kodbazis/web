<?php

namespace Kodbazis\Generated\Course\Update;

use JsonSerializable;

class UpdatedCourse implements JsonSerializable
{
    private $title;
private $invoiceTitle;
private $content;
private $slug;
private $imgUrl;
private $videoId;
private $description;
private $isFinished;
private $price;
private $discount;


    
public function __construct($title, $invoiceTitle, $content, $slug, $imgUrl, $videoId, $description, $isFinished, $price, $discount)
{
        $this->title = $title;
$this->invoiceTitle = $invoiceTitle;
$this->content = $content;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->videoId = $videoId;
$this->description = $description;
$this->isFinished = $isFinished;
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
    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
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
 'isFinished' => $this->isFinished,
 'price' => $this->price,
 'discount' => $this->discount,

        ];
    }
}
