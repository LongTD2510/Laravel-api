<?php
namespace App\Http\Services;

use App\Models\Category;

class CategoryService {
    public function getCategory($params){
        return Category::paginate(5);
    }
}