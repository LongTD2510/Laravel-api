<?php
namespace App\Http\Services;

use App\Consts;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    public function getProduct()
    {
        return Product::paginate(Consts::PAGINATE_PAGE);
    }

    public function createProduct($request)
    {
        return DB::transaction(function () use ($request) {
            $product              = new Product();
            $product->name        = $request['product_name'];
            $product->image_link  = $request['image'];
            $product->price       = $request['price'];
            $product->description = $request['description'];
            if ($request->has('image')) {
                $extension           = $request->image->getClientOriginalExtension();
                $fileName            = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileNameToStore     = '/images/product/' . $fileName . '.' . $extension;
                $path                = $request->file('image')->storeAs('', $fileNameToStore, 'public');
                $imageURL            = Storage::url($path);
                $product->image_link = url($imageURL);
            }
            $product->save();
            return $product;
        }, 5);
    }

    public function getProductById($id)
    {
        return Product::where('id', $id)->firstOrFail();
    }

    public function updateProduct($request)
    {
        # code...
        $resultUpdate = $this->getProductById($request['product_id']);

        $resultUpdate->id          = $request['product_id'];
        $resultUpdate->name        = $request['product_name'];
        $resultUpdate->image_link  = $request['image'];
        $resultUpdate->price       = $request['price'];
        $resultUpdate->description = $request['description'];

        if ($request->has('image')) {
            $extension                = $request->image->getClientOriginalExtension();
            $fileName                 = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameToStore          = '/images/product/' . $fileName . '.' . $extension;
            $path                     = $request->file('image')->storeAs('', $fileNameToStore, 'public');
            $imageURL                 = Storage::url($path);
            $resultUpdate->image_link = url($imageURL);
        }

        $resultUpdate->update();

        return $resultUpdate;
    }

    public function delete($id)
    {
        $delete = Product::findOrFail($id);
        $delete->delete();
        $product = $this->getProduct();
        return $product;
    }

    public function searchProduct($param)
    {
        $startDate   = isset($param['start_date']) ? Carbon::parse(data_get($param, 'start_date'))->startOfDay() : null;
        $nameProduct = isset($param['name_product']) ? $param['name_product'] : null;
        $price       = isset($param['price']) ? $param['price'] : null;
        $results = Product::when(!empty($startDate), function ($q) use ($startDate) {
            $q->where('created_at', '>=', $startDate);
        })->when(!empty($nameProduct), function ($q) use ($nameProduct , $param) {
            $name = trim($param['name_product'], " ");
            $q->where('name', 'LIKE', escapeSpecialChar($name))
                ->orWhere('price', '=', $param['price']);
        })->orderBy('created_at', 'desc');
        return $results->toSql();
        // return $results->paginate(Consts::PAGINATE_PAGE);
    }

    public function validateSearch($param)
    {
        $rule = [
            'name_product' => 'nullable',
            'price'        => 'numeric|min:0',
        ];
        $message = [
            'min' => 'The :attribute must be at least :min.',
        ];
        return Validator::make($param, $rule, $message);
    }
}
