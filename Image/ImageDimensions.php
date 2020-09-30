<?php

namespace Kodbazis\Image;

class ImageDimensions
{
    /**
     * @var string
     */
    private $sizeName;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * ImageDimensions constructor.
     * @param string $sizeName
     * @param int $width
     * @param int $height
     */
    public function __construct(string $sizeName, int $width, int $height)
    {
        $this->sizeName = $sizeName;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getSizeName(): string
    {
        return $this->sizeName;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }




}