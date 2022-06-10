<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\updateProduct;
use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::paginate(5);
        return view('product.product', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('product.addProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $products              = new product;
        $products->name        = $request->name_product;
        $products->price       = $request->price_product;
        $products->description = $request->des_product;

        $request->validate([
            'name_product'  => 'required',
            'image_product' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);
        if ($request->hasfile('image_product')) {
            $file     = $request->image_product;
            $random   = random_int(10000, 99999);
            $fileName = $random . '.' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $products->image_link = $fileName;
            $products->save();
        }
        return redirect()->route('product.index')
            ->with('success', 'Product add successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::find($id);
        return view('product.editProduct', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listProduct(Request $request)
    {
        $products = $this->productService->getProduct($request->all());
        return $this->responseSuccess($products);
    }

    public function updateProduct(CreateOrUpdateRequest $requestProduct)
    {
        $product = $this->productService->updateProduct($requestProduct);
        return $this->responseSuccess($product);
    }

    public function createProduct(updateProduct $requestProduct)
    {
        $product = $this->productService->createProduct($requestProduct);
        return $this->responseSuccess($product);
    }
    
    public function deleteProduct(ProductRequest $productRequest)
    {
        # code...
        $product = $this->productService->delete($productRequest['product_id']);
        return $this->responseSuccess($product);
    }

    public function searchProduct(Request $request)
    {
        $params = $request->only(['name_product','price','start_date']);
        // $params = $request->all();
        // $validator = $this->productService->validateSearch($params);
        // if ($validator->fails()) {
        //     return $this->responseError($validator->messages());
        // }
        $result = $this->productService->searchProduct($params);
        return $this->responseSuccess($result);
    }
}
