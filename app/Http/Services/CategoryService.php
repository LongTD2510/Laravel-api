<?php
namespace App\Http\Services;

use App\Consts;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function getCategory($params)
    {
        return Category::paginate(Consts::PAGINATE_PAGE);
    }
    public function getCateById($param)
    {
        return Category::where('id', $param['category_id'])->first();
    }
    public function updateCategory($param)
    {   
        $firstCate = $this->getCateById($param);
        if(!$firstCate){
            return $firstCate;
        }
        return DB::transaction(function () use( $param, $firstCate) {
            $firstCate->id =  $param['category_'];
            $firstCate->name =  $param['category_name'];
            $firstCate->save();
        });
    }
}
