<?php

namespace App\Modules\Product\Model;

class ProductReadModel
{

    public function __construct(
        public string $title,
        public int $price,
        public string $category,
        public int $quantity
    )
    {
    }
}
