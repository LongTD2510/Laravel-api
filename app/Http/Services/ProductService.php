<?php
namespace App\Http\Services;

use App\Models\Product;

class ProductService {
    public function getProduct($params){
        return Product::paginate(5);
    }
}