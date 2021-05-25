<?php

namespace Kodbazis\Generated\Course;

use JsonSerializable;

class Course implements JsonSerializable
{
    private $id;
private $title;
private $invoiceTitle;
private $content;
private $slug;
private $imgUrl;
private $videoId;
private $description;
private $createdAt;
private $isFinished;
private $price;
private $discount;


    
public function __construct($id, $title, $invoiceTitle, $content, $slug, $imgUrl, $videoId, $description, $createdAt, $isFinished, $price, $discount)
{
        $this->id = $id;
$this->title = $title;
$this->invoiceTitle = $invoiceTitle;
$this->content = $content;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->videoId = $videoId;
$this->description = $description;
$this->createdAt = $createdAt;
$this->isFinished = $isFinished;
$this->price = $price;
$this->discount = $discount;

}
    
    public function getId(): ?int
    {
        return $this->id;
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
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
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
            'id' => $this->id,
 'title' => $this->title,
 'invoiceTitle' => $this->invoiceTitle,
 'content' => $this->content,
 'slug' => $this->slug,
 'imgUrl' => $this->imgUrl,
 'videoId' => $this->videoId,
 'description' => $this->description,
 'createdAt' => $this->createdAt,
 'isFinished' => $this->isFinished,
 'price' => $this->price,
 'discount' => $this->discount,

        ];
    }
}
