<?php
namespace App\Http\Services;

use App\Consts;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

        $resultUpdate->id = $request['product_id'];
        $resultUpdate->name = $request['product_name'];
        $resultUpdate->image_link = $request['image'];
        $resultUpdate->price = $request['price'];
        $resultUpdate->description = $request['description'];

        if ($request->has('image')) {
            $extension          = $request->image->getClientOriginalExtension();
            $fileName           = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameToStore    = '/images/product/' . $fileName . '.' . $extension;
            $path               = $request->file('image')->storeAs('', $fileNameToStore, 'public');
            $imageURL           = Storage::url($path);
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
}
