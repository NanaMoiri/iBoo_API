<?php

namespace App\Model;


class ProductRepositorySearch
{
    public function __construct(
        public readonly ?string $searchText = null,
    ) {
    }
}