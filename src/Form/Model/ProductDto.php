<?php

namespace App\Form\Model;

use App\Entity\Product;

class ProductDto {

    public $type;
    public $name;
    public $description;
    public $weight;
    public $base64Image;
    public $enabled;

    public static function createFromProduct(Product $product): self
    {
        $dto = new self();
        $dto->name = $product->getName();
        return $dto;
    }
}